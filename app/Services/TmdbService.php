<?php

namespace App\Services;

use App\Jobs\FetchPopularMoviesJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
    

    // Funzione per ottenere tutti i film

    public function getPopularMovies($page = 1)
    {
        $cacheKey = "popular_movies_page_{$page}";
        
        return Cache::remember($cacheKey, 3600, function () use ($page) {
            $response = Http::get("{$this->baseUrl}/discover/movie", [
                'api_key' => $this->apiKey,
                'language' => 'it-IT',
                'page' => $page,
            ]);
    
            if ($response->failed()) {
                \Log::error("Errore nella richiesta TMDb per i film popolari.", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
    
                return ['results' => [], 'total_results' => 0];
            }
        
            return $response->json();
        });
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

