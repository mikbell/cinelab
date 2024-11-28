<?php

use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->validData = [
        'title' => 'Hello World',
        'content' => str_repeat('a', Post::CONTENT_MIN_LENGTH),
    ];
});

// Test per l'autenticazione
it('requires authentication', function () {
    post(route('posts.store'))->assertRedirect(route('login'));
});

// Test per salvare un post
it('stores a post', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), $this->validData);

    $this->assertDatabaseHas('posts', [
        ...$this->validData,
        'user_id' => $user->id,
    ]);
});

// Test per il reindirizzamento
it('redirects to the post show page', function () {
    $user = User::factory()->create();

    $response = actingAs($user)
        ->post(route('posts.store'), $this->validData);

    $post = Post::latest('id')->first();

    $response->assertRedirect($post->showRoute());
});

// Test per dati non validi
it('requires valid data', function (array $badData, array|string $errors) {
    actingAs(User::factory()->create())
        ->post(route('posts.store'), [...$this->validData, ...$badData])
        ->assertInvalid($errors);
})->with([
            [['title' => null], 'title'],
            [['title' => true], 'title'],
            [['title' => 1], 'title'],
            [['title' => 1.5], 'title'],
            [['title' => str_repeat('a', Post::TITLE_MAX_LENGTH + 1)], 'title'],
            [['title' => str_repeat('a', Post::TITLE_MIN_LENGTH - 1)], 'title'],
            [['content' => null], 'content'],
            [['content' => true], 'content'],
            [['content' => 1], 'content'],
            [['content' => 1.5], 'content'],
            [['content' => str_repeat('a', Post::CONTENT_MAX_LENGTH + 1)], 'content'],
            [['content' => str_repeat('a', Post::CONTENT_MIN_LENGTH - 1)], 'content'],
        ]);