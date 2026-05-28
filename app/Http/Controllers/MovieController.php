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

        $data = $this->tmdbService->searchMulti($query, $page);
        $movies = $data['results'] ?? [];
        
        // Sadece afişi olan ve kişi olmayan sonuçları filtrele
        $movies = array_filter($movies, function($movie) {
            return !empty($movie['poster_path']) && isset($movie['media_type']) && $movie['media_type'] !== 'person';
        });

        $totalPages = $data['total_pages'] ?? 1;

        return view('movies.search', compact('movies', 'query', 'page', 'totalPages'));
    }
    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');
        if (!$query) {
            return response()->json([]);
        }

        $data = $this->tmdbService->searchMovies($query, 1);
        $results = $data['results'] ?? [];
        
        // Sadece film ve dizileri filtrele (kişileri çıkar)
        $filtered = array_filter($results, function($item) {
            return in_array($item['media_type'] ?? 'movie', ['movie', 'tv']);
        });

        // En fazla 5 sonuç döndür
        $limited = array_slice($filtered, 0, 5);

        // Formatla
        $formatted = array_map(function($item) {
            $isTv = isset($item['media_type']) && $item['media_type'] === 'tv';
            $id = $item['id'];
            return [
                'id' => $id,
                'title' => $item['title'] ?? $item['name'] ?? 'İsimsiz',
                'date' => substr($item['release_date'] ?? $item['first_air_date'] ?? '', 0, 4),
                'poster' => $item['poster_path'] ? "https://image.tmdb.org/t/p/w92{$item['poster_path']}" : null,
                'type' => $isTv ? 'Dizi' : 'Film',
                'url' => $isTv ? route('tv.show', $id) : route('movies.show', $id)
            ];
        }, $limited);

        return response()->json(array_values($formatted));
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
