<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SuperAdmin\StudentDocumentController;
use App\Models\Student;
use App\Services\QrCodeService;
use App\Services\ResultGradingService;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BranchStudentController extends Controller
{
    /**
     * Display students list with search.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $user = $request->user();

        $branch = null;
        if ($user && $user->hasRole(\App\Enums\UserRole::Branch)) {
            $branch = \App\Models\BranchApplication::query()->where('email', $user->email)->first();
        }

        $studentsQuery = Student::query()->with('course');

        if ($branch) {
            $studentsQuery->where(function ($query) use ($branch) {
                $query->where('branch_id', $branch->id)
                    ->orWhere('branch_id', (string) $branch->id)
                    ->orWhere('branch_id', sprintf('%06d', (int) $branch->id));

                if (! empty($branch->username)) {
                    $query->orWhere('branch_id', $branch->username);
                }

                if (! empty($branch->institute_name)) {
                    $query->orWhere('branch_id', $branch->institute_name);
                }
            });
        }

        $students = $studentsQuery
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('registration_number', 'like', '%' . $search . '%')
                        ->orWhere('roll_number', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $courses = \App\Models\Course::query()->where('is_active', true)->orderBy('name')->get();

        return view('students.index', [
            'students' => $students,
            'courses' => $courses,
            'search' => $search,
        ]);
    }


    /**
     * Display student registration details.
     */
    public function show(Student $student): View
    {
        $student->load('course');

        return view('students.show', [
            'student' => $student,
        ]);
    }


    /**
     * Show student edit form.
     */
    public function edit(Student $student): View
    {
        $student->load('course');
        $courses = \App\Models\Course::query()->where('is_active', true)->orderBy('name')->get();

        return view('students.edit', [
            'student' => $student,
            'courses' => $courses,
        ]);
    }


    /**
     * Update student information.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:255'],
            'roll_number' => ['nullable', 'string', 'max:255'],
            'certificate_serial' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'gender' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'district' => ['nullable', 'string', 'max:255'],
            'upazila' => ['nullable', 'string', 'max:255'],
            'passport_nid_number' => ['nullable', 'string', 'max:255'],
            'education_qualification' => ['nullable', 'string', 'max:255'],
            'start_month' => ['nullable', 'string', 'max:50'],
            'end_month' => ['nullable', 'string', 'max:50'],
            'start_year' => ['nullable', 'string', 'max:10'],
            'end_year' => ['nullable', 'string', 'max:10'],
            'session' => ['nullable', 'string', 'max:255'],
            'admitted_at' => ['nullable', 'date'],
            'expire_date' => ['nullable', 'date'],
            'result_status' => ['nullable', 'string', 'max:255'],
            'grade' => ['nullable', 'string', 'max:50'],
            'score' => ['nullable', 'numeric'],
            'branch_id' => ['nullable', 'string', 'max:255'],
            'director_name' => ['nullable', 'string', 'max:255'],
            'institute_name' => ['nullable', 'string', 'max:255'],
            'full_marks' => ['nullable', 'numeric'],
            'written_marks' => ['nullable', 'numeric'],
            'viva_marks' => ['nullable', 'numeric'],
            'practical_marks' => ['nullable', 'numeric'],
            'cgpa' => ['nullable', 'numeric'],
            'publication_date' => ['nullable', 'string', 'max:255'],
            'examination_month' => ['nullable', 'string', 'max:255'],
            'course_id' => ['nullable', 'integer'],
            'duration' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('students', 'public');
        }

        $student->update($validated);

        return redirect()
            ->route('students.index')
            ->with('status', 'Student information updated successfully.');
    }


    /**
     * Display student documents.
     */
    public function document(
        Student $student,
        string $document,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode,
        StudentDocumentController $documentController
    ): View|RedirectResponse {

        $allowedDocuments = [
            'admit-card',
            'registration-card',
            'student-id',
            'certificate',
            'testimonial',
            'transcript',
            'forwarding-letter',
            'results',
        ];

        abort_unless(
            in_array($document, $allowedDocuments, true),
            404
        );

        return $documentController->show(
            $student,
            $document,
            $grading,
            $resultQrCode,
            $qrCode
        );
    }


    /**
     * Delete student.
     */
    public function destroy(Student $student): RedirectResponse
    {
        Gate::authorize('delete', $student);

        DB::transaction(function () use ($student) {
            DB::table('student_result_subjects')
                ->whereIn('student_result_id', function ($query) use ($student) {
                    $query->select('id')->from('student_results')->where('student_id', $student->id);
                })->delete();

            DB::table('student_semester_subjects')
                ->whereIn('student_semester_enrollment_id', function ($query) use ($student) {
                    $query->select('id')->from('student_semester_enrollments')->where('student_id', $student->id);
                })->delete();

            DB::table('student_results')->where('student_id', $student->id)->delete();
            DB::table('student_semester_enrollments')->where('student_id', $student->id)->delete();

            $imagePath = $student->image_path;
            $student->delete();

            if ($imagePath && ! str_starts_with($imagePath, 'http')) {
                Storage::disk('public')->delete($imagePath);
            }
        });

        return back()->with('status', 'Student deleted successfully.');
    }
}
