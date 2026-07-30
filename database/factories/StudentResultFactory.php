<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentResult>
 */
class StudentResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'semester' => 'First Year First Semester',
            'session' => (string) now()->year,
            'status' => 'published',
            'verification_token' => fake()->unique()->sha256(),
            'total_credit' => 28,
            'credit_earned' => 28,
            'gpa' => 3.86,
            'overall_grade' => 'A',
            'published_at' => now(),
        ];
    }
}
