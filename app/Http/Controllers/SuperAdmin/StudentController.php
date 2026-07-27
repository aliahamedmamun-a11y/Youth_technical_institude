<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Student::class);

        return view('super-admin.students.index', [
            'students' => Student::query()->with('course')->latest()->paginate(12),
        ]);
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

        $imagePath = $student->image_path;
        $student->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('super-admin.students.index')->with('status', 'Student deleted successfully.');
    }

    /** @return Collection<int, Course> */
    private function courses(): Collection
    {
        return Course::query()->orderBy('name')->get();
    }
}
