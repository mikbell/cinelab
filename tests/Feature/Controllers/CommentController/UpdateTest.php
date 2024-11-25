<?php

use App\Models\Comment;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('requires authentication', function () {
    put(route('comments.update', Comment::factory()->create()))
        ->assertRedirect(route('login'));
});

it('can update a comment', function () {
    $comment = Comment::factory()->create(['content' => 'This is the old content']);
    $newContent = 'This is the new content';

    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['content' => $newContent]);

    $this->assertDatabaseHas(Comment::class, [
        'id' => $comment->id,
        'content' => $newContent,
    ]);
});

it('redirects to the post show page', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', $comment), ['content' => 'This is the new content'])
        ->assertRedirect(route('posts.show', $comment->post));
});

it('redirects to the correct page of comments', function () {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', ['comment' => $comment, 'page' => 2]), ['content' => 'This is the new content'])
        ->assertRedirect(route('posts.show', ['post' => $comment->post, 'page' => 2]));
});

it('cannot update a comment from another user', function () {
    $comment = Comment::factory()->create();

    actingAs(User::factory()->create())
        ->put(route('comments.update', ['comment' => $comment]), ['content' => 'This is the new content'])
        ->assertForbidden();
});

it('requires a valid content', function ($content) {
    $comment = Comment::factory()->create();

    actingAs($comment->user)
        ->put(route('comments.update', ['comment' => $comment]), ['content' => $content])
        ->assertInvalid('content');
})->with([
            null,
            true,
            1,
            1.5,
            str_repeat('a', 1001),
        ]);