<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TmdbService;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $data = $this->tmdbService->getPopularMovies($page);
        $movies = $data['results'] ?? [];
        $totalPages = $data['total_pages'] ?? 1;

        return view('movies.index', compact('movies', 'page', 'totalPages'));
    }

    public function nowPlaying(Request $request)
    {
        $page = $request->get('page', 1);
        $data = $this->tmdbService->getNowPlayingMovies($page);
        $movies = $data['results'] ?? [];
        $totalPages = $data['total_pages'] ?? 1;

        return view('movies.now_playing', compact('movies', 'page', 'totalPages'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $page = $request->get('page', 1);

        if (!$query) {
            return redirect()->route('movies.index');
        }

        // Sorgunun şahıs ismi olup olmadığını anlamak için TMDB Çoklu Arama yapıyoruz
        $multiData = $this->tmdbService->searchMulti($query, $page);
        $multiResults = $multiData['results'] ?? [];

        // Eğer en alakalı (ilk) sonuç bir "person" (kişi) ise, aramayı bir kişi araması kabul et
        $isQueryPerson = false;
        if (!empty($multiResults)) {
            $firstItem = $multiResults[0];
            if (isset($firstItem['media_type']) && $firstItem['media_type'] === 'person') {
                $isQueryPerson = true;
            }
        }

        if ($isQueryPerson) {
            // Kişi araması ise TMDB'den hiçbir film veya dizi çekmiyoruz (boş bırakıyoruz)
            $movies = [];
            $totalPages = 1;
        } else {
            // Kişi araması değilse, sadece afişi olan film ve dizileri gösteriyoruz
            $movies = array_filter($multiResults, function($item) {
                $mediaType = $item['media_type'] ?? 'movie';
                return $mediaType !== 'person' && !empty($item['poster_path']);
            });
            $totalPages = $multiData['total_pages'] ?? 1;
        }

        // Sitedeki kayıtlı üyeleri ara (Sadece 1. sayfada göster)
        $users = [];
        if ($page == 1) {
            $users = \App\Models\User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->limit(12)
                ->get();
        }

        return view('movies.search', compact('movies', 'users', 'query', 'page', 'totalPages', 'isQueryPerson'));
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');
        if (!$query) {
            return response()->json([]);
        }

        // Sorgunun şahıs ismi olup olmadığını anlamak için TMDB Çoklu Arama yapıyoruz
        $multiData = $this->tmdbService->searchMulti($query, 1);
        $multiResults = $multiData['results'] ?? [];

        // Eğer en alakalı (ilk) sonuç bir "person" ise, aramayı kişi araması kabul et
        $isQueryPerson = false;
        if (!empty($multiResults)) {
            $firstItem = $multiResults[0];
            if (isset($firstItem['media_type']) && $firstItem['media_type'] === 'person') {
                $isQueryPerson = true;
            }
        }

        $formattedTmdb = [];
        if (!$isQueryPerson) {
            // Şahıs ismi değilse, TMDB'den film ve dizileri filtrele
            $filteredTmdb = array_filter($multiResults, function($item) {
                $mediaType = $item['media_type'] ?? 'movie';
                return $mediaType !== 'person';
            });

            // En fazla 4 adet Film/Dizi sonucunu al
            $limitedTmdb = array_slice($filteredTmdb, 0, 4);

            // Formatla
            $formattedTmdb = array_map(function($item) {
                $mediaType = $item['media_type'] ?? 'movie';
                $id = $item['id'];
                $isTv = $mediaType === 'tv';
                return [
                    'id' => $id,
                    'title' => $item['title'] ?? $item['name'] ?? 'İsimsiz',
                    'date' => substr($item['release_date'] ?? $item['first_air_date'] ?? '', 0, 4),
                    'poster' => isset($item['poster_path']) && $item['poster_path'] ? "https://image.tmdb.org/t/p/w92{$item['poster_path']}" : null,
                    'type' => $isTv ? 'Dizi' : 'Film',
                    'url' => $isTv ? route('tv.show', $id) : route('movies.show', $id)
                ];
            }, $limitedTmdb);
        }

        // 2. Sitede kayıtlı üyeleri (kullanıcıları) ara
        $localUsers = \App\Models\User::where('name', 'like', "%{$query}%")
            ->limit(4)
            ->get();

        $formattedUsers = [];
        foreach ($localUsers as $user) {
            $formattedUsers[] = [
                'id' => $user->id,
                'title' => $user->name,
                'date' => 'CineScope Üyesi',
                'poster' => $user->avatar ? asset('avatars/' . $user->avatar) : null,
                'type' => 'Üye',
                'url' => route('profile.show', $user->id)
            ];
        }

        // 3. Sonuçları birleştir
        $combined = array_merge($formattedTmdb, $formattedUsers);

        return response()->json(array_values($combined));
    }

    public function show($id)
    {
        $movie = $this->tmdbService->getMovieDetails($id);
        
        if (!$movie) {
            // Geri Dönüş: Film yerine TV Şovu olup olmadığını kontrol et
            $tvShow = $this->tmdbService->getTvDetails($id);
            if ($tvShow) {
                return redirect()->route('tv.show', $id);
            }
            abort(404);
        }

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->movies()->where('tmdb_id', $id)->exists();
        }

        return view('movies.show', compact('movie', 'isFavorite'));
    }

    public function tvIndex(Request $request)
    {
        $page = $request->get('page', 1);
        $data = $this->tmdbService->getPopularTv($page);
        $movies = $data['results'] ?? [];
        // Bileşenlerin bunun bir dizi olduğunu bilmesi için media_type değerini ata
        foreach($movies as &$m) { $m['media_type'] = 'tv'; }
        $totalPages = $data['total_pages'] ?? 1;

        return view('movies.tv_index', compact('movies', 'page', 'totalPages'));
    }

    public function tvShow($id)
    {
        $movie = $this->tmdbService->getTvDetails($id);
        
        if (!$movie) {
            // Geri Dönüş: TV Şovu yerine Film olup olmadığını kontrol et
            $details = $this->tmdbService->getMovieDetails($id);
            if ($details) {
                return redirect()->route('movies.show', $id);
            }
            abort(404);
        }
        $movie['media_type'] = 'tv';

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->movies()->where('tmdb_id', $id)->exists();
        }

        return view('movies.tv_show', compact('movie', 'isFavorite'));
    }

    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $tmdbId = $request->input('tmdb_id');
        $mediaType = $request->input('media_type', 'movie');
        $title = $request->input('title');
        $posterPath = $request->input('poster_path');
        $releaseDate = $request->input('release_date');
        $voteAverage = $request->input('vote_average');

        $movie = Movie::firstOrCreate(
            ['tmdb_id' => $tmdbId],
            [
                'media_type' => $mediaType,
                'title' => $title,
                'poster_path' => $posterPath,
                'release_date' => $releaseDate,
                'vote_average' => $voteAverage
            ]
        );

        if ($user->movies()->where('movie_id', $movie->id)->exists()) {
            $user->movies()->detach($movie->id);
            return response()->json(['status' => 'removed']);
        } else {
            $user->movies()->attach($movie->id);
            return response()->json(['status' => 'added']);
        }
    }

    public function favorites()
    {
        $movies = Auth::user()->movies()->paginate(20);
        return view('movies.favorites', compact('movies'));
    }
}
