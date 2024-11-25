<?php

use App\Http\Resources\CommentResource;
use App\Models\Post;

use App\Models\Comment;
use function Pest\Laravel\get;
use App\Http\Resources\PostResource;

it('can show a post', function () {
    $post = Post::factory()->create();

    get(route('posts.show', $post))
        ->assertComponent('Posts/Show');
});

it('passes a post to the view', function () {
    $post = Post::factory()->create();
    $post->load('user'); // Carica la relazione con l'utente

    get(route('posts.show', $post))
        ->assertHasResource('post', new PostResource($post));
});


it('passes comments to the view', function () {
    $post = Post::factory()->create();

    $comments = Comment::factory(5)->for($post)->create()->sortBy('created_at');

    get(route('posts.show', $post))
        ->assertHasPaginatedResource(
            'comments',
            CommentResource::collection($comments->values()) // Converte in una Collection ordinata
        );
});
