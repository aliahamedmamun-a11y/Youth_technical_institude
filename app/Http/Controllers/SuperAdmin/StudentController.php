<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\BranchApplication;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Student::class);

        $branchId = $request->input('branch_id') ?: $request->input('branch');
        $showBranches = $request->boolean('show_branches') || $request->routeIs('super-admin.branch-students.index');
        $search = $request->string('search')->trim()->toString();

        if ($branchId) {
            $branch = BranchApplication::query()
                ->where('id', $branchId)
                ->orWhere('username', $branchId)
                ->orWhere('id', (int) $branchId)
                ->first();

            $studentsQuery = Student::query()
                ->with(['course:id,name', 'results'])
                ->where(function ($query) use ($branchId, $branch) {
                    $query->where('branch_id', $branchId)
                        ->orWhere('branch_id', (string) $branchId)
                        ->orWhere('branch_id', sprintf('%06d', (int) $branchId));

                    if ($branch) {
                        if ($branch->id) {
                            $query->orWhere('branch_id', $branch->id)
                                ->orWhere('branch_id', (string) $branch->id)
                                ->orWhere('branch_id', sprintf('%06d', (int) $branch->id));
                        }

                        if (! empty($branch->username)) {
                            $query->orWhere('branch_id', $branch->username);
                        }

                        if (! empty($branch->institute_name)) {
                            $query->orWhere('branch_id', $branch->institute_name);
                        }
                    }
                })
                ->when($search, fn ($query, string $term) => $query->where(fn ($nested) => $nested->where('name', 'like', "%{$term}%")->orWhere('registration_number', 'like', "%{$term}%")->orWhere('roll_number', 'like', "%{$term}%")));

            return view('super-admin.students.branch-students-index', [
                'branch' => $branch,
                'branchId' => $branchId,
                'students' => $studentsQuery->latest()->paginate(12)->withQueryString(),
                'search' => $search,
                'courses' => $this->courses(),
            ]);
        }

        if ($showBranches) {
            $branches = BranchApplication::query()
                ->when($search, fn ($query, string $term) => $query->where('institute_name', 'like', "%{$term}%")->orWhere('username', 'like', "%{$term}%")->orWhere('id', 'like', "%{$term}%")->orWhere('director_name', 'like', "%{$term}%"))
                ->latest()
                ->paginate(12)
                ->withQueryString();

            $branches->getCollection()->transform(function (BranchApplication $branch) {
                $branch->student_count = Student::query()
                    ->where(function ($query) use ($branch) {
                        $query->where('branch_id', $branch->id)
                            ->orWhere('branch_id', (string) $branch->id)
                            ->orWhere('branch_id', sprintf('%06d', (int) $branch->id));

                        if (! empty($branch->username)) {
                            $query->orWhere('branch_id', $branch->username);
                        }

                        if (! empty($branch->institute_name)) {
                            $query->orWhere('branch_id', $branch->institute_name);
                        }
                    })
                    ->count();

                return $branch;
            });

            return view('super-admin.students.branch-list', [
                'branches' => $branches,
                'search' => $search,
            ]);
        }

        return view('super-admin.students.index', [
            'students' => Student::query()
                ->with(['course:id,name', 'results'])
                ->when($search, fn ($query, string $term) => $query->where(fn ($nested) => $nested->where('name', 'like', "%{$term}%")->orWhere('registration_number', 'like', "%{$term}%")->orWhere('roll_number', 'like', "%{$term}%")))
                ->latest()
                ->paginate(12)
                ->withQueryString(),
            'search' => $search,
            'courses' => $this->courses(),
        ]);
    }

    public function branchStudentsAdmin(Request $request): View
    {
        return $this->index($request->merge(['show_branches' => 1]));
    }

    public function create(): View
    {
        Gate::authorize('create', Student::class);

        return view('super-admin.students.create', ['courses' => $this->courses()]);
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        Gate::authorize('create', Student::class);

        $studentData = $request->safe()->except('image');
        $studentData['registration_number'] = $this->registrationNumber();
        $studentData['roll_number'] = ($studentData['roll_number'] ?? null) ?: $this->rollNumber();
        $studentData['result_status'] = 'Pending';

        if ($request->hasFile('image')) {
            $studentData['image_path'] = $request->file('image')->store('students', 'public');
        }

        Student::query()->create($studentData);

        return redirect()->route('super-admin.students.index')->with('status', 'Student added successfully.');
    }

    public function show(Student $student): View
    {
        Gate::authorize('view', $student);

        return view('super-admin.students.show', ['student' => $student->load('course')]);
    }

    public function edit(Student $student): View
    {
        Gate::authorize('update', $student);

        return view('super-admin.students.edit', ['student' => $student, 'courses' => $this->courses()]);
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        Gate::authorize('update', $student);

        $studentData = $request->safe()->except('image');
        $previousImagePath = $student->image_path;

        if ($request->hasFile('image')) {
            $studentData['image_path'] = $request->file('image')->store('students', 'public');
        }

        // Field mappings from modal input names to Student model attributes
        if ($request->filled('full_marks')) {
            $studentData['full_marks'] = $request->input('full_marks');
        } elseif ($request->filled('full_mark')) {
            $studentData['full_marks'] = $request->input('full_mark');
        }

        if ($request->filled('practical_marks')) {
            $studentData['practical_marks'] = $request->input('practical_marks');
        } elseif ($request->filled('practical_mark')) {
            $studentData['practical_marks'] = $request->input('practical_mark');
        }

        if ($request->filled('score')) {
            $studentData['score'] = $request->input('score');
        } elseif ($request->filled('total_marks')) {
            $studentData['score'] = $request->input('total_marks');
        }

        if ($request->filled('grade')) {
            $studentData['grade'] = $request->input('grade');
        } elseif ($request->filled('letter_grade')) {
            $studentData['grade'] = $request->input('letter_grade');
        }

        if ($request->filled('session')) {
            $studentData['session'] = $request->input('session');
        } elseif ($request->filled('session_display')) {
            $studentData['session'] = $request->input('session_display');
        }

        if ($request->filled('publication_date')) {
            $studentData['publication_date'] = $request->input('publication_date');
        }
        if ($request->filled('examination_month')) {
            $studentData['examination_month'] = $request->input('examination_month');
        }
        if ($request->filled('cgpa')) {
            $studentData['cgpa'] = $request->input('cgpa');
        }

        $student->update($studentData);

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
                        'verification_token' => Str::random(48),
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

        if ($request->hasFile('image') && $previousImagePath) {
            Storage::disk('public')->delete($previousImagePath);
        }

        return back()->with('status', 'Student information and result updated successfully.');
    }

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

    public function destroyScore(Student $student): RedirectResponse
    {
        Gate::authorize('update', $student);

        DB::transaction(function () use ($student) {
            DB::table('student_result_subjects')
                ->whereIn('student_result_id', function ($query) use ($student) {
                    $query->select('id')->from('student_results')->where('student_id', $student->id);
                })->delete();

            DB::table('student_results')->where('student_id', $student->id)->delete();

            $student->update([
                'score' => null,
                'grade' => null,
                'result_status' => 'Pending',
                'full_marks' => null,
                'written_marks' => null,
                'viva_marks' => null,
                'practical_marks' => null,
                'cgpa' => null,
                'publication_date' => null,
                'examination_month' => null,
            ]);
        });

        return back()->with('status', 'Student score deleted successfully.');
    }

    /** @return Collection<int, Course> */
    private function courses(): Collection
    {
        return Course::query()->orderBy('name')->get();
    }

    private function registrationNumber(): string
    {
        do {
            $registrationNumber = (string) random_int(10000000, 99999999);
        } while (Student::query()->where('registration_number', $registrationNumber)->exists());

        return $registrationNumber;
    }

    private function rollNumber(): string
    {
        do {
            $rollNumber = (string) random_int(100000, 999999);
        } while (Student::query()->where('roll_number', $rollNumber)->exists());

        return $rollNumber;
    }
}
