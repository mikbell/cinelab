<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
        if (!$this->apiKey) {
            throw new \Exception('La chiave API di TMDb non è configurata.');
        }

        $this->baseUrl = 'https://api.themoviedb.org/3';
    }

    /**
     * Metodo generico per effettuare richieste HTTP all'API TMDb.
     */
    private function fetchFromTmdb(string $endpoint, array $params = [], string $cacheKey = null)
    {
        $cacheKey ??= md5($endpoint . serialize($params));
        
        return Cache::remember($cacheKey, 3600, function () use ($endpoint, $params) {
            $response = Http::get("{$this->baseUrl}{$endpoint}", array_merge($params, [
                'api_key' => $this->apiKey,
                'language' => 'it-IT',
            ]));

            if ($response->failed()) {
                Log::error("Errore nella richiesta TMDb: {$endpoint}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return ['results' => [], 'total_results' => 0];
            }

            return $response->json();
        });
    }

    public function getPopularMovies($page = 1)
    {
        return $this->fetchFromTmdb('/discover/movie', ['page' => $page], "popular_movies_page_{$page}");
    }

    public function getTopRatedMovies($page = 1)
    {
        return $this->fetchFromTmdb('/movie/top_rated', ['page' => $page], "top_rated_movies_page_{$page}");
    }

    public function getNowPlayingMovies($page = 1)
    {
        return $this->fetchFromTmdb('/movie/now_playing', ['page' => $page], "now_playing_movies_page_{$page}");
    }

    public function getMoviesByGenre($genreId, $page = 1)
    {
        return $this->fetchFromTmdb('/discover/movie', [
            'with_genres' => $genreId,
            'page' => $page,
        ], "genre_{$genreId}_movies_page_{$page}");
    }

    public function searchMovies(string $query, int $page = 1)
    {
        return $this->fetchFromTmdb('/search/movie', [
            'query' => $query,
            'page' => $page,
        ]);
    }

    public function getMovieDetails(int|string $movieId)
    {
        return $this->fetchFromTmdb("/movie/{$movieId}");
    }
}
