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
        $applicationData = $request->safe()->except(['director_signature', 'nid_photo', 'director_photo', 'institute_photo']);
        $applicationData['director_signature_path'] = \App\Services\FileUploadService::store($request->file('director_signature'), 'branch-applications/signatures', 'public');
        $applicationData['nid_photo_path'] = \App\Services\FileUploadService::store($request->file('nid_photo'), 'branch-applications/nid', 'public');
        $applicationData['director_photo_path'] = \App\Services\FileUploadService::store($request->file('director_photo'), 'branch-applications/directors', 'public');
        $applicationData['institute_photo_path'] = \App\Services\FileUploadService::store($request->file('institute_photo'), 'branch-applications/institutes', 'public');
        BranchApplication::query()->create($applicationData);

        return redirect()->route('branch-applications.create')->with('status', 'Your branch application has been submitted successfully.');
    }
}
