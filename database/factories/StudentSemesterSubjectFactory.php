<?php

namespace Database\Factories;

use App\Models\StudentSemesterEnrollment;
use App\Models\StudentSemesterSubject;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentSemesterSubject>
 */
class StudentSemesterSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return ['student_semester_enrollment_id' => StudentSemesterEnrollment::factory(), 'subject_id' => Subject::factory(), 'code' => fake()->unique()->numerify('1##'), 'title' => fake()->sentence(3), 'credit' => 3, 'sort_order' => 0];
    }
}
