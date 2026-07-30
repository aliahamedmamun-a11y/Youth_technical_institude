<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentResultRequest;
use App\Http\Requests\UpdateStudentResultRequest;
use App\Models\Student;
use App\Models\StudentResult;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentResultController extends Controller
{
    public function index(Student $student): View
    {
        Gate::authorize('view', $student);

        return view('super-admin.student-results.index', ['student' => $student->load('course'), 'results' => $student->results()->latest()->get()]);
    }

    public function create(Student $student): View
    {
        Gate::authorize('update', $student);

        return view('super-admin.student-results.create', ['student' => $student->load('course')]);
    }

    public function show(StudentResult $result, ResultQrCodeService $qrCode): View
    {
        Gate::authorize('view', $result);

        return view('results.sheet', ['result' => $result->load(['student.course', 'subjects']), 'qrCode' => $qrCode->dataUri($result), 'adminPreview' => true]);
    }

    public function store(StoreStudentResultRequest $request): RedirectResponse
    {
        $student = Student::query()->findOrFail($request->integer('student_id'));
        Gate::authorize('update', $student);

        $result = DB::transaction(function () use ($request, $student): StudentResult {
            $result = $student->results()->create([
                'semester' => $request->string('semester')->toString(),
                'session' => $request->string('session')->toString(),
                'status' => $request->string('status')->toString(),
                'verification_token' => $this->verificationToken(),
                'published_at' => $request->input('status') === 'published' ? now() : null,
            ]);

            $this->replaceSubjects($result, $request->array('subjects'));

            return $result;
        });

        return redirect()->route('super-admin.students.results.index', $student)->with('status', 'Result created successfully.');
    }

    public function edit(StudentResult $result): View
    {
        Gate::authorize('update', $result->student);

        return view('super-admin.student-results.edit', ['result' => $result->load(['student.course', 'subjects'])]);
    }

    public function update(UpdateStudentResultRequest $request, StudentResult $result): RedirectResponse
    {
        Gate::authorize('update', $result->student);

        DB::transaction(function () use ($request, $result): void {
            $result->update([
                'semester' => $request->string('semester')->toString(),
                'session' => $request->string('session')->toString(),
                'status' => $request->string('status')->toString(),
                'published_at' => $request->input('status') === 'published' ? ($result->published_at ?? now()) : null,
            ]);
            $this->replaceSubjects($result, $request->array('subjects'));
        });

        return redirect()->route('super-admin.students.results.index', $result->student)->with('status', 'Result updated successfully.');
    }

    public function destroy(StudentResult $result): RedirectResponse
    {
        Gate::authorize('update', $result->student);
        $student = $result->student;
        $result->delete();

        return redirect()->route('super-admin.students.results.index', $student)->with('status', 'Result deleted successfully.');
    }

    private function replaceSubjects(StudentResult $result, array $subjects): void
    {
        $result->subjects()->delete();
        $totalCredit = 0;
        $creditEarned = 0;
        $qualityPoints = 0;

        foreach (array_values($subjects) as $order => $subject) {
            $credit = (float) $subject['credit'];
            $gradePoint = (float) $subject['grade_point'];
            $totalCredit += $credit;
            $qualityPoints += $credit * $gradePoint;
            if ($gradePoint > 0) {
                $creditEarned += $credit;
            }

            $result->subjects()->create([...$subject, 'sort_order' => $order]);
        }

        $gpa = $totalCredit > 0 ? round($qualityPoints / $totalCredit, 2) : null;
        $result->update([
            'total_credit' => $totalCredit,
            'credit_earned' => $creditEarned,
            'gpa' => $gpa,
            'overall_grade' => $this->overallGrade($gpa),
        ]);
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

    private function verificationToken(): string
    {
        do {
            $token = Str::random(48);
        } while (StudentResult::query()->where('verification_token', $token)->exists());

        return $token;
    }
}
