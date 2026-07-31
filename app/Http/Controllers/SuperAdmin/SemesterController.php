<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SemesterController extends Controller
{
    public function index(Course $course): View
    {
        Gate::authorize('view', $course);

        return view('super-admin.semesters.index', ['course' => $course, 'semesters' => $course->semesters()->withCount('subjects')->get()]);
    }

    public function create(Course $course): View
    {
        Gate::authorize('update', $course);

        return view('super-admin.semesters.create', compact('course'));
    }

    public function store(StoreSemesterRequest $request, Course $course): RedirectResponse
    {
        Gate::authorize('update', $course);
        $course->semesters()->create($request->safe()->except('course_id'));

        return redirect()->route('super-admin.courses.semesters.index', $course)->with('status', 'Semester created successfully.');
    }

    public function edit(Course $course, Semester $semester): View
    {
        Gate::authorize('update', $course);
        abort_unless($semester->course_id === $course->id, 404);

        return view('super-admin.semesters.edit', compact('course', 'semester'));
    }

    public function update(UpdateSemesterRequest $request, Course $course, Semester $semester): RedirectResponse
    {
        Gate::authorize('update', $course);
        abort_unless($semester->course_id === $course->id, 404);
        $semester->update($request->validated());

        return redirect()->route('super-admin.courses.semesters.index', $course)->with('status', 'Semester updated successfully.');
    }

    public function destroy(Course $course, Semester $semester): RedirectResponse
    {
        Gate::authorize('update', $course);
        abort_unless($semester->course_id === $course->id, 404);
        $semester->delete();

        return redirect()->route('super-admin.courses.semesters.index', $course)->with('status', 'Semester deleted successfully.');
    }
}
