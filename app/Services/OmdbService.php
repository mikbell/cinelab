<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OmdbService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.omdb.key');
    }

    public function searchByImdbId(string $imdbId)
    {
        $response = Http::get('http://www.omdbapi.com/', [
            'apikey' => $this->apiKey,
            'i' => $imdbId,
        ]);

        return $response->json();
    }

    public function searchMovies(string $keyword, int $page = 1)
    {
        try {
            $response = Http::get('http://www.omdbapi.com/', [
                'apikey' => $this->apiKey,
                's' => $keyword,
                'page' => $page,
            ]);
    
            if ($response->failed()) {
                logger()->error('OMDB API Request Failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }
    
            $data = $response->json();
            
            // Check for API-specific errors
            if (isset($data['Response']) && $data['Response'] === 'False') {
                logger()->warning('OMDB API Search Error', [
                    'message' => $data['Error'] ?? 'Unknown error'
                ]);
                return null;
            }
    
            return $data;
        } catch (\Exception $e) {
            logger()->error('OMDB Service Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

}
