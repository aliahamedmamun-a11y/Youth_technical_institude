<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Semester>
 */
class SemesterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return ['course_id' => Course::factory(), 'name' => fake()->unique()->words(3, true), 'sort_order' => 1, 'is_active' => true];
    }
}
