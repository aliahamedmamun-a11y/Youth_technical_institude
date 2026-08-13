<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Actions\ApproveBranchApplication;
use App\Enums\BranchApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBranchApplicationStatusRequest;
use App\Models\BranchApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BranchApplicationController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', BranchApplication::class);

        $status = $request->string('status')->toString();
        $search = $request->string('search')->trim()->toString();

        return view('super-admin.branch-applications.index', [
            'applications' => BranchApplication::query()
                ->whereNotNull('username')
                ->when(in_array($status, array_column(BranchApplicationStatus::cases(), 'value'), true), fn ($query) => $query->where('status', $status))
                ->when($search, fn ($query) => $query->where(fn ($nested) => $nested
                    ->where('institute_name', 'like', "%{$search}%")
                    ->orWhere('director_name', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'selectedStatus' => $status,
            'search' => $search,
        ]);
    }

    public function show(BranchApplication $branchApplication): View
    {
        Gate::authorize('view', $branchApplication);

        return view('super-admin.branch-applications.show', compact('branchApplication'));
    }

    public function update(UpdateBranchApplicationStatusRequest $request, BranchApplication $branchApplication, ApproveBranchApplication $approve): RedirectResponse
    {
        Gate::authorize('update', $branchApplication);

        $status = $request->enum('status', BranchApplicationStatus::class);

        if ($status === BranchApplicationStatus::Approved) {
            $approve->handle($branchApplication);
        } else {
            $branchApplication->update([...$request->validated(), 'reviewed_at' => now()]);
        }

        return redirect()->route('super-admin.branch-applications.show', $branchApplication)
            ->with('status', 'Application '.$status->label().' successfully.');
    }
}
