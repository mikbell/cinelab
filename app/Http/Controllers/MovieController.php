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
        $query = $request->query('query', ''); // Query di ricerca
        $page = $request->query('page', 1); // Pagina corrente

        $movies = $this->tmdbService->searchMovies($query, $page);

        return inertia('Movies/Search', [
            'movies' => $movies['results'] ?? [],
            'totalResults' => $movies['total_results'] ?? 0,
            'query' => $query,
            'page' => $page,
        ]);
    }


    public function index(Request $request)
    {
        $page = (int) $request->query('page', 1);
        $movies = $this->tmdbService->getPopularMovies($page);

        return inertia('Movies/Index', [
            'movies' => $movies['results'] ?? [],
            'totalResults' => $movies['total_results'] ?? 0,
            'page' => $page,
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
