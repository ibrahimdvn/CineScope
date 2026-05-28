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

        $data = $this->tmdbService->searchMovies($query, $page);
        $movies = $data['results'] ?? [];
        $totalPages = $data['total_pages'] ?? 1;

        return view('movies.search', compact('movies', 'query', 'page', 'totalPages'));
    }

    public function show($id)
    {
        $movie = $this->tmdbService->getMovieDetails($id);
        
        if (!$movie) {
            abort(404);
        }

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->movies()->where('tmdb_id', $id)->exists();
        }

        return view('movies.show', compact('movie', 'isFavorite'));
    }

    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $tmdbId = $request->input('tmdb_id');
        $title = $request->input('title');
        $posterPath = $request->input('poster_path');
        $releaseDate = $request->input('release_date');
        $voteAverage = $request->input('vote_average');

        $movie = Movie::firstOrCreate(
            ['tmdb_id' => $tmdbId],
            [
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
