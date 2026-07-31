<?php

namespace Database\Factories;

use App\Models\Semester;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return ['semester_id' => Semester::factory(), 'code' => fake()->unique()->numerify('1##'), 'title' => fake()->sentence(3), 'credit' => 3, 'sort_order' => 1, 'is_active' => true];
    }
}
