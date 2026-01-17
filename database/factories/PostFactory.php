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
            'image' => null,
            'is_published' => fake()->boolean(80),
        ];
    }
}
