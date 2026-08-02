<?php

namespace Database\Factories;

use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentSemesterEnrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentSemesterEnrollment>
 */
class StudentSemesterEnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return ['student_id' => Student::factory(), 'semester_id' => Semester::factory(), 'status' => 'assigned', 'assigned_at' => now()];
    }
}
