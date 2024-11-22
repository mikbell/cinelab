<?php

use Inertia\Testing\AssertableInertia;

it('returns the correct component', function () {
    $response = $this->get(route('posts.index'));

    $response->assertInertia(
        fn(AssertableInertia $inertia) => $inertia
            ->component('Posts/Index', true)
    );
});


it('returns the correct component', function () {
    $response = $this->get(route('posts.index'));

    $response->assertInertia(
        fn(AssertableInertia $inertia) => $inertia
            ->has('posts')
    );
});
