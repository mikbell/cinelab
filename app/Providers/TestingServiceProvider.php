<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!$this->app->runningUnitTests()) {
            return;
        }

        // Verifica una risorsa singola
        AssertableInertia::macro('hasResource', function (string $key, JsonResource $resource) {
            $this->has($key);
            expect($this->prop($key))->toEqual($resource->toArray(request()));

            return $this;
        });

        // Verifica una risorsa paginata
        AssertableInertia::macro('hasPaginatedResource', function (string $key, ResourceCollection $resource) {
            $this->hasResource("{$key}.data", $resource);

            // Verifica la presenza di chiavi paginazione standard
            expect($this->prop($key))->toHaveKeys(['data', 'links', 'meta']);
            expect($this->prop("{$key}.links"))->toHaveKeys(['first', 'last', 'prev', 'next']);
            expect($this->prop("{$key}.meta"))->toHaveKeys(['current_page', 'last_page', 'from', 'to', 'total']);

            return $this;
        });

        // Macro per TestResponse - risorsa singola
        TestResponse::macro('assertHasResource', function (string $key, JsonResource $resource) {
            return $this->assertInertia(fn(AssertableInertia $inertia) => $inertia->hasResource($key, $resource));
        });

        // Macro per TestResponse - risorsa paginata
        TestResponse::macro('assertHasPaginatedResource', function (string $key, ResourceCollection $resource) {
            return $this->assertInertia(fn(AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $resource));
        });

        TestResponse::macro('assertComponent', function(string $component) {
            return $this->assertInertia(fn(AssertableInertia $inertia) => $inertia->component($component, true));
        });
    }
}
