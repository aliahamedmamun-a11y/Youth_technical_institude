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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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
                ->with('course:id,name')
                ->where(function ($query) use ($branchId, $branch) {
                    $query->where('branch_id', $branchId)
                        ->orWhere('branch_id', (string) $branchId)
                        ->orWhere('branch_id', sprintf('%06d', (int) $branchId));

                    if ($branch) {
                        $query->orWhere('branch_id', $branch->username)
                            ->orWhere('branch_id', $branch->institute_name);
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
                    ->where('branch_id', $branch->id)
                    ->orWhere('branch_id', (string) $branch->id)
                    ->orWhere('branch_id', sprintf('%06d', $branch->id))
                    ->orWhere('branch_id', $branch->username)
                    ->orWhere('branch_id', $branch->institute_name)
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
                ->with('course:id,name')
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

        $student->update($studentData);

        if ($request->hasFile('image') && $previousImagePath) {
            Storage::disk('public')->delete($previousImagePath);
        }

        return redirect()->route('super-admin.students.show', $student)->with('status', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        Gate::authorize('delete', $student);

        $student->results()->delete();
        $student->semesterEnrollments()->delete();

        $imagePath = $student->image_path;
        $student->delete();

        if ($imagePath && ! str_starts_with($imagePath, 'http')) {
            Storage::disk('public')->delete($imagePath);
        }

        return back()->with('status', 'Student deleted successfully.');
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
