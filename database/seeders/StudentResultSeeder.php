<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentResult;
use App\Services\ResultGradingService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentResultSeeder extends Seeder
{
    public function run(ResultGradingService $grading): void
    {
        Student::query()->with('course')->each(function (Student $student) use ($grading): void {
            $semesters = Semester::query()
                ->whereBelongsTo($student->course)
                ->where('is_active', true)
                ->with('subjects')
                ->orderBy('sort_order')
                ->get();

            foreach ($semesters as $semester) {
                DB::transaction(function () use ($student, $semester, $grading): void {
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
                        $marks = 70 + (($student->id * 7 + $semester->sort_order * 5 + $order * 3) % 26);
                        $grade = $grading->gradeForMarks((float) $marks);
                        $totalCredit += (float) $subject->credit;
                        $qualityPoints += (float) $subject->credit * (float) $grade['grade_point'];
                        $creditEarned += (float) $subject->credit;

                        $result->subjects()->create([
                            'code' => $subject->code,
                            'title' => $subject->title,
                            'credit' => $subject->credit,
                            'marks' => $marks,
                            'grade' => $grade['grade'],
                            'grade_point' => $grade['grade_point'],
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
