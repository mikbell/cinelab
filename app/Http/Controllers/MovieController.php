<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TMDbService;

class MovieController extends Controller
{
    protected $tmdbService;

    public function __construct(TMDbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function search(Request $request)
    {
        $query = $request->query('query', ''); // Recupera la query dalla richiesta
        $page = $request->query('page', 1);

        // Se la query è vuota, restituisci un errore o risultati vuoti
        if (empty($query)) {
            return inertia('Movies/Search', [
                'movies' => [],
                'query' => '',
                'totalResults' => 0,
                'page' => 1,
            ]);
        }

        $movies = $this->tmdbService->searchMovies($query, $page);

        return inertia('Movies/Search', [
            'movies' => $movies['results'] ?? [],
            'query' => $query,
            'totalResults' => $movies['total_results'] ?? 0,
            'page' => $page,
        ]);
    }

    public function index(Request $request)
    {
        $page = (int) $request->query('page', 1); // Converte il valore in intero
        $movies = $this->tmdbService->getPopularMovies($page);
    
        return inertia('Movies/Index', [
            'movies' => $movies['results'] ?? [],
            'totalResults' => $movies['total_results'] ?? 0,
            'page' => $page, // Passa la pagina come numero
        ]);
    }
    

    public function show($id)
    {
        $movie = $this->tmdbService->getMovieDetails($id);

        return inertia('Movies/Show', [
            'movie' => $movie,
        ]);
    }
}
