<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Semester;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(Request $request, Semester $semester): View
    {
        Gate::authorize('view', $semester->course);

        $search = $request->string('search')->trim()->toString();
        $status = $request->string('status')->toString();

        return view('super-admin.subjects.index', ['semester' => $semester->load('course'), 'search' => $search, 'selectedStatus' => $status, 'subjects' => $semester->subjects()->when($search, fn ($query) => $query->where(fn ($nested) => $nested->where('title', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%")))->when(in_array($status, ['active', 'inactive'], true), fn ($query) => $query->where('is_active', $status === 'active'))->get()]);
    }

    public function create(Semester $semester): View
    {
        Gate::authorize('update', $semester->course);

        return view('super-admin.subjects.create', compact('semester'));
    }

    public function store(StoreSubjectRequest $request, Semester $semester): RedirectResponse
    {
        Gate::authorize('update', $semester->course);
        $semester->subjects()->create($request->safe()->except('semester_id'));

        return redirect()->route('super-admin.semesters.subjects.index', $semester)->with('status', 'Subject created successfully.');
    }

    public function edit(Semester $semester, Subject $subject): View
    {
        Gate::authorize('update', $semester->course);
        abort_unless($subject->semester_id === $semester->id, 404);

        return view('super-admin.subjects.edit', compact('semester', 'subject'));
    }

    public function update(UpdateSubjectRequest $request, Semester $semester, Subject $subject): RedirectResponse
    {
        Gate::authorize('update', $semester->course);
        abort_unless($subject->semester_id === $semester->id, 404);
        $subject->update($request->validated());

        return redirect()->route('super-admin.semesters.subjects.index', $semester)->with('status', 'Subject updated successfully.');
    }

    public function destroy(Semester $semester, Subject $subject): RedirectResponse
    {
        Gate::authorize('update', $semester->course);
        abort_unless($subject->semester_id === $semester->id, 404);
        $subject->delete();

        return redirect()->route('super-admin.semesters.subjects.index', $semester)->with('status', 'Subject deleted successfully.');
    }
}
