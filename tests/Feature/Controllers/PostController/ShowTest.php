<?php

use App\Http\Resources\CommentResource;
use App\Models\Post;

use App\Models\Comment;
use function Pest\Laravel\get;
use App\Http\Resources\PostResource;

it('can show a post', function () {
    $post = Post::factory()->create();

    get($post->showRoute())
        ->assertComponent('Posts/Show');
});

it('passes a post to the view', function () {
    $post = Post::factory()->create();
    $post->load('user'); // Carica la relazione con l'utente

    get($post->showRoute())
        ->assertHasResource('post', new PostResource($post));
});


it('passes comments to the view', function () {
    $post = Post::factory()->create();

    $comments = Comment::factory(5)->for($post)->create()->sortBy('created_at');

    get($post->showRoute())
        ->assertHasPaginatedResource(
            'comments',
            CommentResource::collection($comments->reverse()) // Converte in una Collection ordinata
        );
})->only();

it('will redirect if the slug is incorrect', function () {
    $post = Post::factory()->create(['title' => 'Hello world']);

    get(route('posts.show', [$post, 'foo-bar', 'page' => 2]))
        ->assertRedirect($post->showRoute(['page' => 2]));
});