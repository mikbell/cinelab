<?php

namespace Database\Factories;

use App\Models\Topic;
use App\Models\User;
use App\Support\PostFixtures;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    private static Collection $fixtures;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'topic_id' => Topic::factory(),
            'title' => str(fake()->sentence())->beforeLast('.')->title(),
            'content' => Collection::times(5, fn() => fake()->realText(1250))->join(PHP_EOL . PHP_EOL),
        ];
    }

    public function withFixture(): static
    {
        return $this->sequence(...PostFixtures::getFixtures());
    }
}
