<?php

namespace Database\Factories;

use App\Models\InstituteProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InstituteProfile>
 */
class InstituteProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'about_heading' => 'Education that moves beyond the classroom.',
            'summary' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'principal_name' => fake()->name(),
            'principal_title' => 'Principal',
            'principal_image_path' => null,
            'image_path' => null,
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
            'is_published' => true,
        ];
    }
}
