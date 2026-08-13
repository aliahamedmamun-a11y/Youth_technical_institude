<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentResultRequest;
use App\Http\Requests\StoreStudentResultRequest;
use App\Http\Requests\UpdateStudentResultRequest;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\StudentSemesterEnrollment;
use App\Services\ResultGradingService;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentResultController extends Controller
{
    public function index(Request $request, Student $student): View
    {
        Gate::authorize('view', $student);

        $status = $request->string('status')->toString();

        return view('super-admin.student-results.index', ['student' => $student->load('course'), 'selectedStatus' => $status, 'results' => $student->results()->when(in_array($status, ['published', 'draft'], true), fn ($query) => $query->where('status', $status))->with('subjects')->latest()->get()]);
    }

    public function create(Student $student): View
    {
        Gate::authorize('update', $student);

        $student->load('course.semesters');

        return view('super-admin.student-results.create', ['student' => $student, 'semesters' => $student->course->semesters->where('is_active', true)]);
    }

    public function createForEnrollment(StudentSemesterEnrollment $enrollment): View
    {
        Gate::authorize('update', $enrollment->student);
        $enrollment->load(['student', 'semester', 'subjects']);

        return view('super-admin.student-results.enrollment-create', compact('enrollment'));
    }

    public function storeForEnrollment(StoreEnrollmentResultRequest $request, StudentSemesterEnrollment $enrollment, ResultGradingService $grading): RedirectResponse
    {
        Gate::authorize('update', $enrollment->student);
        $enrollment->load(['student', 'semester', 'subjects']);
        $markRows = collect($request->array('subjects'))->keyBy(fn (array $row): int => (int) $row['id']);
        $assignedSubjects = $enrollment->subjects;

        abort_unless($markRows->keys()->diff($assignedSubjects->pluck('id'))->isEmpty(), 422);
        $rows = $assignedSubjects->map(function ($assignedSubject) use ($markRows, $grading): array {
            $marks = $markRows->get($assignedSubject->id)['marks'] ?? null;
            $grade = $grading->gradeForMarks($marks === null || $marks === '' ? null : (float) $marks);

            return ['code' => $assignedSubject->code, 'title' => $assignedSubject->title, 'credit' => $assignedSubject->credit, 'marks' => $marks === '' ? null : $marks, 'grade' => $grade['grade'], 'grade_point' => $grade['grade_point'], 'sort_order' => $assignedSubject->sort_order];
        });

        if ($request->string('status')->toString() === 'published' && $rows->contains(fn (array $row): bool => $row['marks'] === null)) {
            return back()->withErrors(['subjects' => 'Every subject must have marks before publishing.'])->withInput();
        }

        $summary = $grading->summarize($rows->map(fn (array $row): array => ['credit' => $row['credit'], 'grade_point' => $row['grade_point']])->all());
        $result = DB::transaction(function () use ($request, $enrollment, $rows, $summary): StudentResult {
            $result = StudentResult::query()->firstOrNew(['student_semester_enrollment_id' => $enrollment->id]);
            $result->fill(['student_id' => $enrollment->student_id, 'semester_id' => $enrollment->semester_id, 'semester' => $enrollment->semester->name, 'session' => $request->string('session')->toString(), 'status' => $request->string('status')->toString(), 'verification_token' => $result->verification_token ?? $this->verificationToken(), 'published_at' => $request->string('status')->toString() === 'published' ? ($result->published_at ?? now()) : null, ...$summary]);
            $result->save();
            $result->subjects()->delete();
            $result->subjects()->createMany($rows->all());

            return $result;
        });

        return redirect()->route('super-admin.results.edit', $result)->with('status', 'Marks saved successfully.');
    }

    public function show(StudentResult $result, ResultQrCodeService $qrCode): View
    {
        Gate::authorize('view', $result);

        $result->load(['student.course', 'subjects']);

        return view('results.sheet', ['result' => $result, 'cumulativeGpa' => app(ResultGradingService::class)->cumulativeGpa($result->student), 'qrCode' => $qrCode->dataUri($result), 'adminPreview' => true]);
    }

    public function store(StoreStudentResultRequest $request): RedirectResponse
    {
        $student = Student::query()->findOrFail($request->integer('student_id'));
        Gate::authorize('update', $student);
        $semester = $this->semesterForStudent($request->input('semester_id') ? (int) $request->input('semester_id') : null, $student);

        $result = DB::transaction(function () use ($request, $student, $semester): StudentResult {
            $result = $student->results()->create([
                'semester_id' => $semester?->id,
                'semester' => $semester?->name ?? $request->string('semester')->toString(),
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

        if ($result->student_semester_enrollment_id !== null) {
            $result->load(['student', 'enrollment.semester', 'enrollment.subjects', 'subjects']);

            return view('super-admin.student-results.enrollment-edit', compact('result'));
        }

        $result->load(['student.course.semesters', 'subjects']);

        return view('super-admin.student-results.edit', ['result' => $result, 'semesters' => $result->student->course->semesters->where('is_active', true)]);
    }

    public function update(UpdateStudentResultRequest $request, StudentResult $result): RedirectResponse
    {
        Gate::authorize('update', $result->student);
        $semester = $this->semesterForStudent($request->input('semester_id') ? (int) $request->input('semester_id') : null, $result->student);

        DB::transaction(function () use ($request, $result, $semester): void {
            $result->update([
                'semester_id' => $semester?->id,
                'semester' => $semester?->name ?? $request->string('semester')->toString(),
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

    private function semesterForStudent(?int $semesterId, Student $student): ?Semester
    {
        if ($semesterId === null) {
            return null;
        }

        return Semester::query()->whereKey($semesterId)->whereBelongsTo($student->course)->with('subjects')->firstOrFail();
    }
}
