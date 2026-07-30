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
        $applicationData = $request->safe()->except(['director_signature', 'nid_photo', 'director_photo']);
        $applicationData['director_signature_path'] = $request->file('director_signature')->store('branch-applications/signatures', 'public');
        $applicationData['nid_photo_path'] = $request->file('nid_photo')->store('branch-applications/nid', 'public');
        $applicationData['director_photo_path'] = $request->file('director_photo')->store('branch-applications/directors', 'public');
        BranchApplication::query()->create($applicationData);

        return redirect()->route('branch-applications.create')->with('status', 'Your branch application has been submitted successfully.');
    }
}
