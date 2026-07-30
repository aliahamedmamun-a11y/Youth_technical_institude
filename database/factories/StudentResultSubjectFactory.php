<?php

namespace Database\Factories;

use App\Models\StudentResult;
use App\Models\StudentResultSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentResultSubject>
 */
class StudentResultSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_result_id' => StudentResult::factory(),
            'code' => fake()->unique()->numerify('1##'),
            'title' => fake()->sentence(3),
            'credit' => 3,
            'marks' => fake()->numberBetween(60, 95),
            'grade' => 'A',
            'grade_point' => 4,
            'sort_order' => 0,
        ];
    }
}
