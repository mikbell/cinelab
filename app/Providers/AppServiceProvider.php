<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Providers\TestingServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Model::preventLazyLoading();

        if ($this->app->environment('testing')) {
            $this->app->register(TestingServiceProvider::class);
        }

        Relation::enforceMorphMap([
            'post' => Post::class,
            'comment' => Comment::class
        ]);

    }
}
