<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentSemesterEnrollmentRequest;
use App\Http\Requests\UpdateStudentSemesterEnrollmentRequest;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentSemesterEnrollment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StudentSemesterEnrollmentController extends Controller
{
    public function index(Student $student): View
    {
        Gate::authorize('view', $student);

        return view('super-admin.student-enrollments.index', ['student' => $student->load('course'), 'enrollments' => $student->semesterEnrollments()->with(['semester', 'subjects', 'results'])->latest()->get()]);
    }

    public function create(Student $student): View
    {
        Gate::authorize('update', $student);
        $student->load('course.semesters.subjects');

        return view('super-admin.student-enrollments.create', ['student' => $student, 'semesters' => $student->course->semesters->where('is_active', true)]);
    }

    public function store(StoreStudentSemesterEnrollmentRequest $request, Student $student): RedirectResponse
    {
        Gate::authorize('update', $student);
        $semester = $this->semesterForStudent($request->integer('semester_id'), $student);
        $subjectIds = array_map('intval', $request->array('subjects'));
        $subjects = $semester->subjects()->where('is_active', true)->whereIn('id', $subjectIds)->get();
        $this->ensureAllSubjectsSelected($subjectIds, $subjects->pluck('id')->all());

        $enrollment = DB::transaction(function () use ($student, $semester, $subjects): StudentSemesterEnrollment {
            $enrollment = $student->semesterEnrollments()->create(['semester_id' => $semester->id, 'status' => 'assigned', 'assigned_at' => now()]);
            $this->replaceEnrollmentSubjects($enrollment, $subjects);

            return $enrollment;
        });

        return redirect()->route('super-admin.students.semester-enrollments.index', $student)->with('status', 'Semester assigned successfully.');
    }

    public function edit(Student $student, StudentSemesterEnrollment $semesterEnrollment): View
    {
        Gate::authorize('update', $student);
        abort_unless($semesterEnrollment->student_id === $student->id, 404);
        $semesterEnrollment->load(['semester.subjects', 'subjects']);

        return view('super-admin.student-enrollments.edit', ['student' => $student, 'enrollment' => $semesterEnrollment]);
    }

    public function update(UpdateStudentSemesterEnrollmentRequest $request, Student $student, StudentSemesterEnrollment $semesterEnrollment): RedirectResponse
    {
        Gate::authorize('update', $student);
        abort_unless($semesterEnrollment->student_id === $student->id, 404);
        abort_if($semesterEnrollment->results()->exists(), 409, 'This assignment cannot be changed after marks have been entered.');
        $subjects = $semesterEnrollment->semester->subjects()->where('is_active', true)->whereIn('id', array_map('intval', $request->array('subjects')))->get();
        $this->ensureAllSubjectsSelected($request->array('subjects'), $subjects->pluck('id')->all());
        $this->replaceEnrollmentSubjects($semesterEnrollment, $subjects);

        return redirect()->route('super-admin.students.semester-enrollments.index', $student)->with('status', 'Assigned subjects updated successfully.');
    }

    public function destroy(Student $student, StudentSemesterEnrollment $semesterEnrollment): RedirectResponse
    {
        Gate::authorize('update', $student);
        abort_unless($semesterEnrollment->student_id === $student->id, 404);
        abort_if($semesterEnrollment->results()->exists(), 409, 'This assignment cannot be deleted after marks have been entered.');
        $semesterEnrollment->delete();

        return redirect()->route('super-admin.students.semester-enrollments.index', $student)->with('status', 'Semester assignment removed.');
    }

    private function semesterForStudent(int $semesterId, Student $student): Semester
    {
        return Semester::query()->whereKey($semesterId)->whereBelongsTo($student->course)->firstOrFail();
    }

    private function replaceEnrollmentSubjects(StudentSemesterEnrollment $enrollment, Collection $subjects): void
    {
        $enrollment->subjects()->delete();
        foreach ($subjects as $order => $subject) {
            $enrollment->subjects()->create(['subject_id' => $subject->id, 'code' => $subject->code, 'title' => $subject->title, 'credit' => $subject->credit, 'sort_order' => $order]);
        }
    }

    private function ensureAllSubjectsSelected(array $requestedIds, array $allowedIds): void
    {
        if (array_diff(array_unique(array_map('intval', $requestedIds)), array_map('intval', $allowedIds)) !== []) {
            throw ValidationException::withMessages(['subjects' => 'One or more selected subjects are not available for this semester.']);
        }
    }
}
