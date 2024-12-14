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

        // Film per generi
        $genreIds = [
            28 => 'actionMovies', // Azione
            35 => 'comedyMovies', // Commedia
            18 => 'dramaMovies',  // Dramma
        ];

        $moviesByGenre = [];
        foreach ($genreIds as $genreId => $key) {
            $moviesByGenre[$key] = $this->tmdbService->getMoviesByGenre($genreId, $page)['results'] ?? [];
        }

        return inertia('Dashboard', array_merge([
            'popularMovies' => $popularMovies['results'] ?? [],
            'topRatedMovies' => $topRatedMovies['results'] ?? [],
            'recentMovies' => $recentMovies['results'] ?? [],
            'page' => $page,
        ], $moviesByGenre));
    }

    public function index(Request $request)
    {
        $page = (int) $request->query('page', 1);
        $genre = $request->query('genre');
        $query = $request->query('query');

        if ($query) {
            // Cerca i film in base alla query
            $movies = $this->tmdbService->searchMovies($query, $page);
        } elseif ($genre) {
            // Filtra i film in base al genere
            $movies = $this->tmdbService->getMoviesByGenre($genre, $page);
        } else {
            // Ottieni i film popolari
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
