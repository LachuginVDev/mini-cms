<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Database\Seeders\SettingSeeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Сначала создаем настройки
        $this->call(SettingSeeder::class);

        // Создаем админа
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
            'role' => 'admin',
        ]);

        // Создаем обычных пользователей
        User::factory(5)->create();

        // Создаем категории
        Category::factory(5)->create();

        // Создаем посты (с картинками из picsum.photos)
        Post::factory(20)->create();

        // Создаем комментарии для постов
        $users = User::all();
        $posts = Post::all();

        foreach ($posts as $post) {
            Comment::factory(rand(1, 5))->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
