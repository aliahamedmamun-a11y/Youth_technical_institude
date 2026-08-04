<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_by' => User::factory(),
            'title' => fake()->sentence(5),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->sentence(12),
            'content' => fake()->paragraphs(3, true),
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
