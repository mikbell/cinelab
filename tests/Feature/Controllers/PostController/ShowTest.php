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
    $post->load('user', 'topic'); // Carica la relazione con l'utente

    get($post->showRoute())
        ->assertHasResource('post', new PostResource($post)->withLikePermission());
});


it('passes comments to the view', function () {
    $post = Post::factory()->create();
    $comments = Comment::factory(2)->for($post)->create();

    $comments->load('user');

    $expectedResource = CommentResource::collection($comments->reverse());
    $expectedResource->collection->transform(fn (CommentResource $resource) => $resource->withLikePermission());

    get($post->showRoute())
        ->assertHasPaginatedResource('comments', $expectedResource);
});

it('will redirect if the slug is incorrect', function () {
    $post = Post::factory()->create(['title' => 'Hello world']);

    get(route('posts.show', [$post, 'foo-bar', 'page' => 2]))
        ->assertRedirect($post->showRoute(['page' => 2]));
})->with(['foo-bar', 'hello']);