<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentResultSeeder extends Seeder
{
    public function run(): void
    {
        $student = Student::query()->with('course')->first();

        if (! $student) {
            return;
        }

        $semester = Semester::query()
            ->whereBelongsTo($student->course)
            ->where('name', 'First Semester')
            ->with('subjects')
            ->firstOrFail();

        DB::transaction(function () use ($student, $semester): void {
            $result = StudentResult::query()
                ->where('student_id', $student->id)
                ->where('session', 'July 2025 - December 2025')
                ->where(function ($query) use ($semester): void {
                    $query->where('semester_id', $semester->id)->orWhere('semester', $semester->name);
                })
                ->first() ?? new StudentResult;

            $result->fill([
                'student_id' => $student->id,
                'semester_id' => $semester->id,
                'semester' => $semester->name,
                'session' => 'July 2025 - December 2025',
                'status' => 'published',
                'verification_token' => $result->verification_token ?? Str::random(48),
                'published_at' => $result->published_at ?? now(),
            ]);
            $result->save();

            $result->subjects()->delete();
            $totalCredit = 0;
            $qualityPoints = 0;
            $creditEarned = 0;

            foreach ($semester->subjects as $order => $subject) {
                $gradePoint = [4, 3.75, 3.5, 3.25][$order] ?? 3;
                $totalCredit += (float) $subject->credit;
                $qualityPoints += (float) $subject->credit * $gradePoint;
                $creditEarned += (float) $subject->credit;

                $result->subjects()->create([
                    'code' => $subject->code,
                    'title' => $subject->title,
                    'credit' => $subject->credit,
                    'marks' => [88, 82, 78, 91][$order] ?? 80,
                    'grade' => ['A+', 'A-', 'B+', 'A+'][$order] ?? 'B+',
                    'grade_point' => $gradePoint,
                    'sort_order' => $order,
                ]);
            }

            $gpa = $totalCredit > 0 ? round($qualityPoints / $totalCredit, 2) : null;
            $result->update([
                'total_credit' => $totalCredit,
                'credit_earned' => $creditEarned,
                'gpa' => $gpa,
                'overall_grade' => $this->overallGrade($gpa),
            ]);
        });
    }

    private function overallGrade(?float $gpa): ?string
    {
        return match (true) {
            $gpa === null => null,
            $gpa >= 4 => 'A+',
            $gpa >= 3.75 => 'A',
            $gpa >= 3.5 => 'A-',
            $gpa >= 3.25 => 'B+',
            $gpa >= 3 => 'B',
            $gpa >= 2.75 => 'B-',
            $gpa >= 2.5 => 'C+',
            $gpa >= 2 => 'C',
            $gpa >= 1.65 => 'D',
            default => 'F',
        };
    }
}
