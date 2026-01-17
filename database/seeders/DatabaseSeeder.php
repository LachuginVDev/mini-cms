<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
            'role' => 'admin',
        ]);

        User::factory(5)->create();
        Category::factory(5)->create();
        Post::factory(20)->create();

        $users = User::all();
        $posts = Post::all();

        foreach ($posts as $post) {
            Comment::factory(rand(1,5))->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
