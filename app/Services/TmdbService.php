<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
        $this->baseUrl = 'https://api.themoviedb.org/3';
    }

    // Funzione per ottenere tutti i film
    public function getAllMovies($maxPages = 5)
    {
        $allMovies = [];
        $page = 1;

        do {
            $response = Http::get("{$this->baseUrl}/discover/movie", [
                'api_key' => $this->apiKey,
                'language' => 'it-IT',
                'page' => $page,
            ]);

            $data = $response->json();

            if (isset($data['results'])) {
                $allMovies = array_merge($allMovies, $data['results']);
            }

            $page++;
        } while ($page <= ($data['total_pages'] ?? 0) && $page <= $maxPages);

        return $allMovies;
    }

    // Funzione per cercare film
    public function searchMovies(string $query, int $page = 1)
    {
        $response = Http::get("{$this->baseUrl}/search/movie", [
            'api_key' => $this->apiKey,
            'query' => $query,
            'page' => $page,
            'language' => 'it-IT', // Per risultati in italiano
        ]);

        return $response->json();
    }

    public function getMovieDetails(int|string $movieId)
    {
        $response = Http::get("{$this->baseUrl}/movie/{$movieId}", [
            'api_key' => $this->apiKey,
            'language' => 'it-IT',
        ]);
    
        return $response->json();
    }
    
}

