<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), 'employee_number' => fake()->unique()->bothify('T-####'), 'email' => fake()->unique()->safeEmail(), 'phone' => fake()->numerify('01#########'), 'designation' => 'Instructor', 'department' => 'Computer', 'qualification' => 'BSc in CSE', 'joined_at' => fake()->dateTimeBetween('-5 years', 'now'), 'is_active' => true,
        ];
    }
}
