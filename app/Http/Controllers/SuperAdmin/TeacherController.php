<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Teacher::class);

        $search = $request->string('search')->trim()->toString();

        return view('super-admin.teachers.index', [
            'teachers' => Teacher::query()
                ->when($search, fn ($query) => $query->where(fn ($nested) => $nested->where('name', 'like', "%{$search}%")->orWhere('employee_number', 'like', "%{$search}%")->orWhere('designation', 'like', "%{$search}%")))
                ->latest()
                ->paginate(12)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Teacher::class);

        return view('super-admin.teachers.create');
    }

    public function store(StoreTeacherRequest $request): RedirectResponse
    {
        Gate::authorize('create', Teacher::class);
        $teacherData = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $teacherData['image_path'] = $request->file('image')->store('teachers', 'public');
        }

        Teacher::query()->create($teacherData);

        return redirect()->route('super-admin.teachers.index')->with('status', 'Teacher added successfully.');
    }

    public function show(Teacher $teacher): View
    {
        Gate::authorize('view', $teacher);

        return view('super-admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher): View
    {
        Gate::authorize('update', $teacher);

        return view('super-admin.teachers.edit', compact('teacher'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher): RedirectResponse
    {
        Gate::authorize('update', $teacher);
        $teacherData = $request->safe()->except('image');
        $previousImagePath = $teacher->image_path;

        if ($request->hasFile('image')) {
            $teacherData['image_path'] = $request->file('image')->store('teachers', 'public');
        }

        $teacher->update($teacherData);

        if ($request->hasFile('image') && $previousImagePath) {
            Storage::disk('public')->delete($previousImagePath);
        }

        return redirect()->route('super-admin.teachers.index')->with('status', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        Gate::authorize('delete', $teacher);
        $imagePath = $teacher->image_path;
        $teacher->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()->route('super-admin.teachers.index')->with('status', 'Teacher deleted successfully.');
    }
}
