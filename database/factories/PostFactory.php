<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'title' => fake()->sentence(6),
            'content' => fake()->paragraphs(5, true),
            'meta_title' => fake()->sentence(6),
            'meta_description' => fake()->sentence(12),
            'image' => 'https://picsum.photos/800/500?random=' . fake()->numberBetween(1, 5000),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
        ];
    }
}
