<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OmdbService;

class OmdbController extends Controller
{
    protected $omdbService;

    public function __construct(OmdbService $omdbService)
    {
        $this->omdbService = $omdbService;
    }

    public function show($id)
    {
        $data = $this->omdbService->searchByImdbId($id);

        return inertia('Movies/Show', compact('data'));
    }

    public function index(Request $request)
    {
        $keyword = $request->query('keyword', 'Batman'); // Usa una stringa vuota come default
        $page = $request->query('page', 1);

        try {
            $movies = $this->omdbService->searchMovies($keyword, $page);
        } catch (\Exception $e) {
            // Gestisci l'errore
            return inertia('Movies/Index', [
                'movies' => [],
                'totalResults' => 0,
                'defaultKeyword' => $keyword,
                'error' => $e->getMessage(),
            ]);
        }

        if (is_array($movies) && array_key_exists('Search', $movies)) {
            return inertia('Movies/Index', [
                'movies' => $movies['Search'],
                'totalResults' => $movies['totalResults'] ?? 0,
                'defaultKeyword' => $keyword,
            ]);
        } else {
            return inertia('Movies/Index', [
                'movies' => [],
                'totalResults' => 0,
                'defaultKeyword' => $keyword,
            ]);
        }
    }
}
