<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = 'https://api.themoviedb.org/3';
        $this->apiKey = config('services.tmdb.key');
    }

    public function getPopularMovies($page = 1)
    {
        return $this->get('/movie/popular', ['page' => $page]);
    }

    public function getPopularTv($page = 1)
    {
        return $this->get('/tv/popular', ['page' => $page]);
    }

    public function getNowPlayingMovies($page = 1)
    {
        return $this->get('/movie/now_playing', ['page' => $page]);
    }

    public function searchMulti($query, $page = 1)
    {
        return $this->get('/search/multi', ['query' => $query, 'page' => $page]);
    }

    public function searchMovies($query, $page = 1)
    {
        return $this->get('/search/movie', ['query' => $query, 'page' => $page]);
    }

    public function getMovieDetails($id)
    {
        return $this->get("/movie/{$id}", ['append_to_response' => 'similar']);
    }

    public function getTvDetails($id)
    {
        return $this->get("/tv/{$id}", ['append_to_response' => 'similar']);
    }

    protected function get($endpoint, $params = [])
    {
        $params['api_key'] = $this->apiKey;
        $params['language'] = 'tr-TR';

        $response = Http::get("{$this->baseUrl}{$endpoint}", $params);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
