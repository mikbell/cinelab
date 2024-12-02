<?php

namespace Database\Seeders;

use App\Models\Like;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicSeeder::class);

        $topics = Topic::all();

        $users = User::factory(20)
            ->create();

        $posts = Post::factory(200)
            ->withFixture()->has(Comment::factory(15)
                ->recycle($users))->recycle([$users, $topics])
            ->create();

        $testUser = User::factory()
            ->has(Post::factory(50)->recycle($topics)->withFixture())
            ->has(Comment::factory(120)->recycle($posts))
            ->has(Like::factory()->forEachSequence(
                ...$posts->random(100)->map(fn(Post $post) => ['likeable_id' => $post])
            ))
            ->create([
                'name' => 'Test User',
                'email' => 'a@a',
                'password' => bcrypt('a'),
            ]);
    }
}
