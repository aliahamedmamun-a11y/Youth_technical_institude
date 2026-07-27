<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\BranchApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBranchApplicationStatusRequest;
use App\Models\BranchApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BranchApplicationController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', BranchApplication::class);

        return view('super-admin.branch-applications.index', ['applications' => BranchApplication::query()->latest()->paginate(15)]);
    }

    public function show(BranchApplication $branchApplication): View
    {
        Gate::authorize('view', $branchApplication);

        return view('super-admin.branch-applications.show', compact('branchApplication'));
    }

    public function update(UpdateBranchApplicationStatusRequest $request, BranchApplication $branchApplication): RedirectResponse
    {
        Gate::authorize('update', $branchApplication);

        $branchApplication->update([
            ...$request->validated(),
            'reviewed_at' => now(),
        ]);

        $status = $request->enum('status', BranchApplicationStatus::class);

        return redirect()->route('super-admin.branch-applications.show', $branchApplication)
            ->with('status', 'Application '.$status->label().' successfully.');
    }
}
