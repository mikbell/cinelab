<?php

use App\Models\Post;

it('uses title case for titles', function () {
    $post = Post::factory()->create(['title' => 'hello world']);
    expect($post->title)->toBe('Hello World');
});