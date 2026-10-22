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

        $user = $request->user();
        if ($user && $user->hasRole(\App\Enums\UserRole::Branch)) {
            $branch = \App\Models\BranchApplication::query()->where('email', $user->email)->first();

            if ($branch && isset($validated['result_status']) && in_array(strtolower((string) $validated['result_status']), ['published', 'passed'], true) && ! ($branch->allow_result_publish ?? true)) {
                return back()->with('error', 'Result publishing is disabled for your branch by Super Admin.');
            }
        }

        $student->update($validated);

        // Update semester-wise GPAs, Grades and Subjects in student_results dynamically
        $semestersInput = $request->input('semesters');
        if (! is_array($semestersInput)) {
            $semestersInput = [];
        }

        $semCgpa = $request->input('semester_cgpa');
        $semGrade = $request->input('semester_grade');

        if (is_array($semCgpa)) {
            foreach ($semCgpa as $semKey => $cgpaVal) {
                if (! isset($semestersInput[$semKey]) || empty($semestersInput[$semKey]['cgpa'])) {
                    $semestersInput[$semKey] = [
                        'cgpa' => $cgpaVal,
                        'grade' => is_array($semGrade) ? ($semGrade[$semKey] ?? null) : null,
                    ];
                }
            }
        }

        // Group course_subjects by semester
        $courseSubjectsBySem = [];
        if ($request->has('course_subjects') && is_array($request->input('course_subjects'))) {
            foreach ($request->input('course_subjects') as $cSub) {
                if (! empty($cSub['semester'])) {
                    $semRaw = (string) $cSub['semester'];
                    $semTitle = str_contains($semRaw, 'Semester') ? $semRaw : $semRaw.' Semester';
                    $courseSubjectsBySem[$semTitle][] = $cSub;
                }
            }
        }

        // Group simple subjects by semester
        $simpleSubjectsBySem = [];
        if ($request->has('subjects') && is_array($request->input('subjects'))) {
            foreach ($request->input('subjects') as $sSub) {
                $semRaw = $sSub['semester'] ?? $sSub['semester_name'] ?? '1st';
                $semTitle = str_contains((string) $semRaw, 'Semester') ? $semRaw : $semRaw.' Semester';
                $titleVal = $sSub['subject'] ?? $sSub['title'] ?? $sSub['name'] ?? null;
                if ($titleVal) {
                    $simpleSubjectsBySem[$semTitle][] = $titleVal;
                }
            }
        }

        // Collect all distinct semesters
        $allSemKeys = array_unique(array_merge(
            array_keys($semestersInput),
            array_map(fn ($s) => str_replace(' Semester', '', $s), array_keys($courseSubjectsBySem)),
            array_map(fn ($s) => str_replace(' Semester', '', $s), array_keys($simpleSubjectsBySem))
        ));

        foreach ($allSemKeys as $semKey) {
            $semTitle = str_contains((string) $semKey, 'Semester') ? $semKey : $semKey.' Semester';
            $semData = $semestersInput[$semKey] ?? $semestersInput[str_replace(' Semester', '', $semKey)] ?? [];
            $cgpaVal = $semData['cgpa'] ?? null;
            $gradeVal = $semData['grade'] ?? null;

            $hasCourseSubs = ! empty($courseSubjectsBySem[$semTitle]);
            $hasSimpleSubs = ! empty($simpleSubjectsBySem[$semTitle]);

            if ($cgpaVal !== null || $gradeVal !== null || $hasCourseSubs || $hasSimpleSubs) {
                $result = $student->results()->firstOrCreate(
                    ['semester' => $semTitle],
                    [
                        'session' => $student->session ?: '2024 - 2025',
                        'total_credit' => 28,
                        'credit_earned' => 28,
                        'gpa' => ! empty($cgpaVal) ? (float) $cgpaVal : ($student->cgpa ?: 3.75),
                        'overall_grade' => $gradeVal ?: ($student->grade ?: 'A'),
                        'status' => 'published',
                        'published_at' => now(),
                        'verification_token' => \Illuminate\Support\Str::random(48),
                    ]
                );

                $result->update([
                    'session' => $student->session ?: $result->session ?: '2024 - 2025',
                    'gpa' => ! empty($cgpaVal) ? (float) $cgpaVal : ($result->gpa ?: $student->cgpa ?: 3.75),
                    'overall_grade' => $gradeVal ?: ($result->overall_grade ?: $student->grade ?: 'A'),
                    'status' => 'published',
                    'published_at' => $result->published_at ?? now(),
                ]);

                if ($hasCourseSubs) {
                    $result->subjects()->delete();
                    $rows = [];
                    foreach ($courseSubjectsBySem[$semTitle] as $sortIdx => $cSub) {
                        $codeVal = $cSub['code'] ?? sprintf('CSE-%03d', $sortIdx + 101);
                        $rows[] = [
                            'code' => $codeVal,
                            'title' => $cSub['title'] ?? $cSub['name'] ?? 'Subject',
                            'credit' => ! empty($cSub['credit']) ? (float) $cSub['credit'] : 3.0,
                            'marks' => ! empty($cSub['marks']) ? (float) $cSub['marks'] : null,
                            'grade' => $cSub['grade'] ?? 'A',
                            'grade_point' => ! empty($cSub['grade_point']) ? (float) $cSub['grade_point'] : 3.75,
                            'sort_order' => $sortIdx,
                        ];
                    }
                    $result->subjects()->createMany($rows);
                } elseif ($hasSimpleSubs) {
                    $result->subjects()->delete();
                    $rows = [];
                    foreach ($simpleSubjectsBySem[$semTitle] as $sortIdx => $subTitle) {
                        $rows[] = [
                            'code' => sprintf('SUB-%03d', $sortIdx + 101),
                            'title' => $subTitle,
                            'credit' => 3.0,
                            'marks' => 80,
                            'grade' => $result->overall_grade ?: 'A',
                            'grade_point' => $result->gpa ?: 3.75,
                            'sort_order' => $sortIdx,
                        ];
                    }
                    $result->subjects()->createMany($rows);
                }
            }
        }

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
            'certificate-one',
            'certificate-two',
            'testimonial',
            'transcript',
            'transcript-one',
            'transcript-two',
            'forwarding-letter',
            'results',
            'results-2',
        ];

        abort_unless(
            in_array($document, $allowedDocuments, true),
            404
        );

        $user = auth()->user();
        if ($user && $user->hasRole(\App\Enums\UserRole::Branch)) {
            $branch = \App\Models\BranchApplication::query()->where('email', $user->email)->first();

            if ($branch) {
                if (in_array($document, ['certificate', 'certificate-one', 'certificate-two'], true) && ! ($branch->allow_certificate ?? true)) {
                    return back()->with('error', 'Certificate access is disabled for your branch by Super Admin.');
                }
                if ($document === 'testimonial' && ! ($branch->allow_testimonial ?? true)) {
                    return back()->with('error', 'Testimonial access is disabled for your branch by Super Admin.');
                }
                if (($document === 'transcript' || $document === 'transcript-one' || $document === 'transcript-two') && ! ($branch->allow_transcript ?? true)) {
                    return back()->with('error', 'Transcript access is disabled for your branch by Super Admin.');
                }
            }
        }

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
