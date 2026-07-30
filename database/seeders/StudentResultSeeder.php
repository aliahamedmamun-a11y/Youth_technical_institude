<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StudentResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = Student::query()->first();

        if (! $student) {
            return;
        }

        $result = StudentResult::query()->updateOrCreate(
            ['student_id' => $student->id, 'semester' => 'First Year First Semester', 'session' => 'July 2025 - December 2025'],
            ['status' => 'published', 'verification_token' => Str::random(48), 'published_at' => now()],
        );

        $subjects = [
            ['code' => '101', 'title' => 'Principles of Management', 'credit' => 4, 'marks' => 72, 'grade' => 'B', 'grade_point' => 3],
            ['code' => '102', 'title' => 'Business Communication', 'credit' => 3, 'marks' => 86, 'grade' => 'A+', 'grade_point' => 4],
            ['code' => '103', 'title' => 'Accounting', 'credit' => 4, 'marks' => 88, 'grade' => 'A+', 'grade_point' => 4],
            ['code' => '104', 'title' => 'Business Mathematics', 'credit' => 3, 'marks' => 89, 'grade' => 'A+', 'grade_point' => 4],
            ['code' => '105', 'title' => 'Marketing Management', 'credit' => 4, 'marks' => 90, 'grade' => 'A+', 'grade_point' => 4],
            ['code' => '106', 'title' => 'Human Resource Management', 'credit' => 3, 'marks' => 91, 'grade' => 'A+', 'grade_point' => 4],
            ['code' => '107', 'title' => 'Computer Application in Business', 'credit' => 3, 'marks' => 87, 'grade' => 'A+', 'grade_point' => 4],
            ['code' => '108', 'title' => 'Business Organization and Entrepreneurship', 'credit' => 4, 'marks' => 88, 'grade' => 'A+', 'grade_point' => 4],
        ];

        $result->subjects()->delete();
        foreach ($subjects as $order => $subject) {
            $result->subjects()->create([...$subject, 'sort_order' => $order]);
        }
        $result->update(['total_credit' => 28, 'credit_earned' => 28, 'gpa' => 3.86, 'overall_grade' => 'A']);
    }
}
