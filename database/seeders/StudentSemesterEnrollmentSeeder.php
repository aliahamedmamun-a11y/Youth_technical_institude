<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSemesterEnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        Student::query()->with('course.semesters.subjects')->each(function (Student $student): void {
            foreach ($student->course->semesters->where('is_active', true) as $semester) {
                DB::transaction(function () use ($student, $semester): void {
                    $enrollment = $student->semesterEnrollments()->updateOrCreate(
                        ['semester_id' => $semester->id],
                        ['status' => 'assigned'],
                    );

                    $enrollment->subjects()->delete();
                    $enrollment->subjects()->createMany($semester->subjects->map(
                        fn ($subject, int $sortOrder): array => [
                            'subject_id' => $subject->id,
                            'code' => $subject->code,
                            'title' => $subject->title,
                            'credit' => $subject->credit,
                            'sort_order' => $sortOrder,
                        ],
                    )->all());
                });
            }
        });
    }
}
