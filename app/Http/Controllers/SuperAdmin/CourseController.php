<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Course::class);

        return view('super-admin.courses.index', [
            'courses' => Course::query()
                ->when($request->string('search')->trim()->toString(), fn ($query, string $search) => $query->where('name', 'like', "%{$search}%"))
                ->when(in_array($request->string('status')->toString(), ['active', 'inactive'], true), fn ($query) => $query->where('is_active', $request->string('status')->toString() === 'active'))
                ->latest()->paginate(12)->withQueryString(),
            'search' => $request->string('search')->trim()->toString(),
            'selectedStatus' => $request->string('status')->toString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', Course::class);

        return view('super-admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request): RedirectResponse
    {
        Gate::authorize('create', Course::class);

        $courseData = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $courseData['image_path'] = $request->file('image')->store('courses', 'public');
        }

        Course::query()->create($courseData);

        return redirect()->route('super-admin.courses.index')->with('status', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): View
    {
        Gate::authorize('view', $course);

        return view('super-admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): View
    {
        Gate::authorize('update', $course);

        return view('super-admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        Gate::authorize('update', $course);

        $courseData = $request->safe()->except('image');
        $previousImagePath = $course->image_path;

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('courses', 'public');
            $courseData['image_path'] = $newImagePath;
        }

        $course->update($courseData);

        if ($request->hasFile('image') && $previousImagePath) {
            Storage::disk('public')->delete($previousImagePath);
        }

        return redirect()->route('super-admin.courses.index')->with('status', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        Gate::authorize('delete', $course);

        $imagePath = $course->image_path;
        $course->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('super-admin.courses.index')->with('status', 'Course deleted successfully.');
    }
}
