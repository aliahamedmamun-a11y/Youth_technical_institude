<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'name' => fake()->name(),
            'registration_number' => fake()->unique()->bothify('BNYTI-####-###'),
            'roll_number' => fake()->numerify('####'),
            'father_name' => fake()->name('male'),
            'mother_name' => fake()->name('female'),
            'phone' => fake()->numerify('01#########'),
            'email' => fake()->safeEmail(),
            'gender' => fake()->randomElement(['Male', 'Female', 'Other']),
            'date_of_birth' => fake()->dateTimeBetween('-25 years', '-16 years'),
            'address' => fake()->address(),
            'admitted_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'result_status' => 'Passed',
            'grade' => 'A',
            'score' => 85,
        ];
    }
}
