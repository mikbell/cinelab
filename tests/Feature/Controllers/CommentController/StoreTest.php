<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;


it('requires authentication', function () {
    post(route('posts.comments.store', Post::factory()->create()))
    ->assertRedirect(route('login'));
});

it('can store a comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    actingAs($user)->post(route('posts.comments.store', $post), [
        'content' => 'test comment',
    ]);

    $this->assertDatabaseHas(Comment::class, [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'test comment',
    ]);
});

it('redirects to the post', function () {
    $post = Post::factory()->create();

    actingAs(User::factory()->create())->post(route('posts.comments.store', $post), [
        'content' => 'test comment',
    ])->assertRedirect(route('posts.show', $post));
});

it('requires valid content', function ($value) {
    $post = Post::factory()->create();

    actingAs(User::factory()->create())->post(route('posts.comments.store', $post), [
        'content' => $value,
    ])->assertInvalid('content');
})->with([
            null,
            '',
            ' ',
            0,
            -1,
            str_repeat('a', 1001),
        ]);