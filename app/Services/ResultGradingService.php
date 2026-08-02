<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentResult;

class ResultGradingService
{
    /**
     * @return array{grade: string|null, grade_point: float|null}
     */
    public function gradeForMarks(?float $marks): array
    {
        if ($marks === null) {
            return ['grade' => null, 'grade_point' => null];
        }

        return match (true) {
            $marks >= 80 => ['grade' => 'A+', 'grade_point' => 4.0],
            $marks >= 75 => ['grade' => 'A', 'grade_point' => 3.75],
            $marks >= 70 => ['grade' => 'A-', 'grade_point' => 3.5],
            $marks >= 65 => ['grade' => 'B+', 'grade_point' => 3.25],
            $marks >= 60 => ['grade' => 'B', 'grade_point' => 3.0],
            $marks >= 55 => ['grade' => 'B-', 'grade_point' => 2.75],
            $marks >= 50 => ['grade' => 'C+', 'grade_point' => 2.5],
            $marks >= 45 => ['grade' => 'C', 'grade_point' => 2.25],
            $marks >= 40 => ['grade' => 'D', 'grade_point' => 2.0],
            default => ['grade' => 'F', 'grade_point' => 0.0],
        };
    }

    /**
     * @param  list<array{credit: float|int|string, grade_point: float|int|string|null}>  $subjects
     * @return array{total_credit: float, credit_earned: float, gpa: float|null, overall_grade: string|null}
     */
    public function summarize(array $subjects): array
    {
        $totalCredit = 0.0;
        $creditEarned = 0.0;
        $qualityPoints = 0.0;
        $hasPendingMarks = false;

        foreach ($subjects as $subject) {
            $credit = (float) $subject['credit'];
            $gradePoint = $subject['grade_point'] === null ? null : (float) $subject['grade_point'];
            $totalCredit += $credit;
            if ($gradePoint === null) {
                $hasPendingMarks = true;

                continue;
            }

            $qualityPoints += $credit * $gradePoint;

            if ($gradePoint > 0) {
                $creditEarned += $credit;
            }
        }

        $gpa = ! $hasPendingMarks && $totalCredit > 0 ? round($qualityPoints / $totalCredit, 2) : null;

        return [
            'total_credit' => $totalCredit,
            'credit_earned' => $creditEarned,
            'gpa' => $gpa,
            'overall_grade' => $this->overallGrade($gpa),
        ];
    }

    public function cumulativeGpa(Student $student): ?float
    {
        $results = StudentResult::query()
            ->whereBelongsTo($student)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->whereNotNull('gpa')
            ->get(['total_credit', 'gpa']);

        $totalCredit = $results->sum(fn (StudentResult $result): float => (float) $result->total_credit);
        $qualityPoints = $results->sum(fn (StudentResult $result): float => (float) $result->total_credit * (float) $result->gpa);

        return $totalCredit > 0 ? round($qualityPoints / $totalCredit, 2) : null;
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
