<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentResult;

class ResultGradingService
{
    /** @var list<array{range: string, minimum_mark: int, grade: string, grade_point: float}> */
    private const GRADING_SCALE = [
        ['range' => '80 or Above', 'minimum_mark' => 80, 'grade' => 'A+', 'grade_point' => 4.0],
        ['range' => '75 - Below 80', 'minimum_mark' => 75, 'grade' => 'A', 'grade_point' => 3.75],
        ['range' => '70 - Below 75', 'minimum_mark' => 70, 'grade' => 'A-', 'grade_point' => 3.5],
        ['range' => '65 - Below 70', 'minimum_mark' => 65, 'grade' => 'B+', 'grade_point' => 3.25],
        ['range' => '60 - Below 65', 'minimum_mark' => 60, 'grade' => 'B', 'grade_point' => 3.0],
        ['range' => '55 - Below 60', 'minimum_mark' => 55, 'grade' => 'B-', 'grade_point' => 2.75],
        ['range' => '50 - Below 55', 'minimum_mark' => 50, 'grade' => 'C+', 'grade_point' => 2.5],
        ['range' => '45 - Below 50', 'minimum_mark' => 45, 'grade' => 'C', 'grade_point' => 2.25],
        ['range' => '40 - Below 45', 'minimum_mark' => 40, 'grade' => 'D', 'grade_point' => 2.0],
        ['range' => 'Below 40', 'minimum_mark' => 0, 'grade' => 'F', 'grade_point' => 0.0],
    ];

    /**
     * @return array{grade: string|null, grade_point: float|null}
     */
    public function gradeForMarks(?float $marks): array
    {
        if ($marks === null) {
            return ['grade' => null, 'grade_point' => null];
        }

        foreach (self::GRADING_SCALE as $gradeBand) {
            if ($marks >= $gradeBand['minimum_mark']) {
                return [
                    'grade' => $gradeBand['grade'],
                    'grade_point' => $gradeBand['grade_point'],
                ];
            }
        }

        return ['grade' => 'F', 'grade_point' => 0.0];
    }

    /**
     * @return list<array{range: string, minimum_mark: int, grade: string, grade_point: float}>
     */
    public function gradingScale(): array
    {
        return self::GRADING_SCALE;
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
            'overall_grade' => $this->letterGradeForGpa($gpa),
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

    public function letterGradeForGpa(?float $gpa): ?string
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
            $gpa >= 2.25 => 'C',
            $gpa >= 2 => 'D',
            default => 'F',
        };
    }
}
