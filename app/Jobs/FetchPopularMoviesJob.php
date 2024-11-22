<?php

namespace App\Jobs;

use App\Services\TMDbService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchPopularMoviesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $maxPages;
    protected $maxMovies;

    public function __construct($maxPages = 5, $maxMovies = null)
    {
        $this->maxPages = $maxPages;
        $this->maxMovies = $maxMovies;
    }

    public function handle(TMDbService $tmdbService)
    {
        $movies = $tmdbService->getPopularMovies($this->maxPages, $this->maxMovies);
    }
}
