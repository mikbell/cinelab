<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TMDbService;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected $tmdbService;

    public function __construct(TMDbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }



    public function dashboard(Request $request)
    {
        $page = (int) $request->query('page', 1);

        // Film popolari
        $popularMovies = $this->tmdbService->getPopularMovies($page);

        // Film più votati
        $topRatedMovies = $this->tmdbService->getTopRatedMovies($page);

        // Film recenti
        $recentMovies = $this->tmdbService->getNowPlayingMovies($page);

        // Film per genere (esempio: Azione)
        $genreId = 28; // ID del genere Azione
        $actionMovies = $this->tmdbService->getMoviesByGenre($genreId, $page);

        return inertia('Dashboard', [
            'popularMovies' => $popularMovies['results'] ?? [],
            'topRatedMovies' => $topRatedMovies['results'] ?? [],
            'recentMovies' => $recentMovies['results'] ?? [],
            'actionMovies' => $actionMovies['results'] ?? [],
            'page' => $page,
        ]);
    }

    public function index(Request $request)
    {
        $page = (int) $request->query('page', 1);
        $genre = $request->query('genre');
        $query = $request->query('query');

        if ($query) {
            $movies = $this->tmdbService->searchMovies($query, $page);
        } elseif ($genre) {
            $movies = $this->tmdbService->getMoviesByGenre($genre, $page);
        } else {
            $movies = $this->tmdbService->getPopularMovies($page);
        }

        return $request->expectsJson()
            ? response()->json([
                'movies' => $movies['results'] ?? [],
                'total_results' => $movies['total_results'] ?? 0,
                'page' => $page,
            ])
            : inertia('Movies/Index', [
                'initialMovies' => $movies['results'] ?? [],
                'totalResults' => $movies['total_results'] ?? 0,
                'initialPage' => $page,
                'genres' => $this->tmdbService->getGenres(),
            ]);
    }

    public function show($id)
    {
        $movie = app(TmdbService::class)->getMovieDetails($id);

        if (!$movie) {
            abort(404, 'Film non trovato.');
        }

        return inertia('Movies/Show', [
            'movie' => $movie,
        ]);
    }

}
