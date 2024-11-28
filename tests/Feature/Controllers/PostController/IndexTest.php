<?php

use App\Models\Post;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\get;

it('should return the correct component', function () {
    get(route('posts.index'))
        ->assertInertia(fn (AssertableInertia $inertia) => $inertia
            ->component('Posts/Index', true)
        );
});

it('passes posts to the view', function () {
    $posts = Post::factory(3)->create();

    get(route('posts.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('posts.data', 3) // Verifica che ci siano 3 post
            ->where('posts.data.0.id', $posts->last()->id) // L'ultimo creato diventa il primo
            ->where('posts.data.1.id', $posts[1]->id)
            ->where('posts.data.2.id', $posts->first()->id)
        );
});
