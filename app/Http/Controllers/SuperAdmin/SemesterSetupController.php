<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SemesterSetupController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Course::class);

        return view('super-admin.semester-setup.index', ['courses' => Course::query()->withCount('semesters')->orderBy('name')->get()]);
    }
}
