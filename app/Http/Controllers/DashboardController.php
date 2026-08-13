<?php

namespace App\Http\Controllers;

use App\Enums\BranchApplicationStatus;
use App\Models\BranchApplication;
use App\Models\Course;
use App\Models\News;
use App\Models\Notice;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        return redirect()->route($request->user()->role->dashboardRoute());
    }

    public function superAdmin(): View
    {
        return view('dashboards.super-admin', [
            'statistics' => [
                'students' => Student::query()->count(),
                'teachers' => Teacher::query()->count(),
                'courses' => Course::query()->where('is_active', true)->count(),
                'pendingBranches' => BranchApplication::query()->where('status', BranchApplicationStatus::Pending->value)->count(),
            ],
            'pendingApplications' => BranchApplication::query()
                ->where('status', BranchApplicationStatus::Pending->value)
                ->latest()
                ->limit(5)
                ->get(['id', 'institute_name', 'director_name', 'district', 'created_at']),
            'recentActivity' => collect([
                ...Student::query()->latest()->limit(3)->get(['id', 'name', 'created_at'])->map(fn (Student $student): array => ['label' => $student->name, 'type' => 'Student registered', 'date' => $student->created_at, 'url' => route('super-admin.students.show', $student)]),
                ...Notice::query()->latest()->limit(2)->get(['id', 'title', 'created_at'])->map(fn (Notice $notice): array => ['label' => $notice->title, 'type' => 'Notice updated', 'date' => $notice->created_at, 'url' => route('super-admin.notices.edit', $notice)]),
                ...News::query()->latest()->limit(2)->get(['id', 'title', 'created_at'])->map(fn (News $news): array => ['label' => $news->title, 'type' => 'News updated', 'date' => $news->created_at, 'url' => route('super-admin.news.edit', $news)]),
                ...BranchApplication::query()->where('status', BranchApplicationStatus::Pending->value)->latest()->limit(2)->get(['id', 'institute_name', 'created_at'])->map(fn (BranchApplication $application): array => ['label' => $application->institute_name, 'type' => 'Branch application submitted', 'date' => $application->created_at, 'url' => route('super-admin.branch-applications.show', $application)]),
            ])->sortByDesc('date')->take(6),
        ]);
    }

    public function branch(): View
    {
        return view('dashboards.branch');
    }

    public function editor(): View
    {
        return view('dashboards.editor');
    }

    public function student(): View
    {
        return view('dashboards.student');
    }
}
