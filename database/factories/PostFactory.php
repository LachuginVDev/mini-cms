<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Генерируем случайный ID для уникальных изображений (до 1084 - это реальное количество изображений на picsum.photos)
        $imageId = fake()->numberBetween(1, 1084);
        
        // Используем Picsum Photos - сервис для генерации случайных изображений
        // Формат: https://picsum.photos/id/{id}/800/500
        // Это более надежный вариант, чем ?random=, так как использует конкретный ID
        $imageUrl = 'https://picsum.photos/id/' . $imageId . '/800/500';
        
        return [
            'title' => fake()->sentence(6),
            'content' => fake()->paragraphs(5, true),
            'meta_title' => fake()->sentence(6),
            'meta_description' => fake()->sentence(12),
            'image' => $imageUrl,
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'category_id' => Category::inRandomOrder()->first()?->id,
        ];
    }
}
