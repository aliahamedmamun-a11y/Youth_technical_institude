<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchApplicationRequest;
use App\Models\BranchApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BranchApplicationController extends Controller
{
    public function create(): View
    {
        return view('branch-applications.create');
    }

    public function store(StoreBranchApplicationRequest $request): RedirectResponse
    {
        BranchApplication::query()->create($request->validated());

        return redirect()->route('branch-applications.create')->with('status', 'Your branch application has been submitted successfully.');
    }
}
