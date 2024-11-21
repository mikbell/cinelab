<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        $posts = Post::factory(200)->recycle($users)->create();
        $comments = Comment::factory(100)->recycle($users)->recycle($posts)->create();

        $testUser = User::factory()->has(Post::factory(50))->has(Comment::factory(120)->recycle($posts))->create([
            'name' => 'Test User',
            'email' => 'a@a',
            'password' => bcrypt('a'),
        ]);
    }
}
