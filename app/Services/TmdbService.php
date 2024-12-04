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
        $response = $this->fetchFromTmdb('/discover/movie', ['page' => $page], "popular_movies_page_{$page}");

        Log::info('TMDb Total Results:', ['total_results' => $response['total_results'] ?? 0]);

        return $response;
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
        Log::info("Chiamata API per genere: {$genreId}, pagina: {$page}");

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

    public function getFilteredMovies($page = 1, $filters = [])
    {
        $defaultFilters = [
            'sort_by' => 'popularity.desc',
            'include_adult' => false,
            'include_video' => false,
            'page' => $page,
        ];

        return $this->fetchFromTmdb('/discover/movie', array_merge($defaultFilters, $filters), "filtered_movies_page_{$page}");
    }

    public function getMultiplePagesMovies($startPage = 1, $endPage = 3)
    {
        $movies = [];

        for ($page = $startPage; $page <= $endPage; $page++) {
            $response = $this->getPopularMovies($page);
            $movies = array_merge($movies, $response['results']);
        }

        return [
            'results' => $movies,
            'total_results' => count($movies),
        ];
    }

    public function getGenres()
    {
        return Cache::remember('movie_genres', 86400, function () {
            $response = Http::get("{$this->baseUrl}/genre/movie/list", [
                'api_key' => $this->apiKey,
                'language' => 'it-IT',
            ]);

            return $response->json()['genres'] ?? [];
        });
    }


}
