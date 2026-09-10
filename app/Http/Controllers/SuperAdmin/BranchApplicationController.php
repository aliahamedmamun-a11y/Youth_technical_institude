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
                ->when($status, function ($query) use ($status) {
                    if (in_array($status, array_column(BranchApplicationStatus::cases(), 'value'), true)) {
                        return $query->where('status', $status);
                    }
                }, function ($query) {
                    return $query->where('status', '!=', BranchApplicationStatus::Approved);
                })
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

    public function allBranches(Request $request): View
    {
        Gate::authorize('viewAny', BranchApplication::class);

        $search = $request->string('search')->trim()->toString();

        return view('super-admin.branch-applications.all-branches', [
            'branches' => BranchApplication::query()
                ->where('status', BranchApplicationStatus::Approved)
                ->when($search, fn ($query) => $query->where(fn ($nested) => $nested
                    ->where('institute_name', 'like', "%{$search}%")
                    ->orWhere('director_name', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")))
                ->latest()
                ->paginate(20)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function show(BranchApplication $branchApplication): View
    {
        Gate::authorize('view', $branchApplication);

        return view('super-admin.branch-applications.show', compact('branchApplication'));
    }

    public function edit(BranchApplication $branchApplication): View
    {
        Gate::authorize('update', $branchApplication);

        return view('super-admin.branch-applications.edit', compact('branchApplication'));
    }

    public function updateData(Request $request, BranchApplication $branchApplication): RedirectResponse
    {
        Gate::authorize('update', $branchApplication);

        $validated = $request->validate([
            'institute_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'director_name' => ['required', 'string', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:30'],
            'district' => ['required', 'string'],
            'upazila' => ['required', 'string'],
            'director_photo' => ['nullable', 'image', 'max:2048'],
            'institute_photo' => ['nullable', 'image', 'max:2048'],
            'nid_photo' => ['nullable', 'image', 'max:2048'],
            'director_signature' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('director_photo')) {
            $validated['director_photo_path'] = $request->file('director_photo')->store('branch-applications/directors', 'public');
        }
        if ($request->hasFile('institute_photo')) {
            $validated['institute_photo_path'] = $request->file('institute_photo')->store('branch-applications/institutes', 'public');
        }
        if ($request->hasFile('nid_photo')) {
            $validated['nid_photo_path'] = $request->file('nid_photo')->store('branch-applications/nid', 'public');
        }
        if ($request->hasFile('director_signature')) {
            $validated['director_signature_path'] = $request->file('director_signature')->store('branch-applications/signatures', 'public');
        }

        $branchApplication->update($validated);

        // Update user name/email if they changed
        \App\Models\User::query()->where('email', $branchApplication->getOriginal('email'))->update([
            'name' => $branchApplication->director_name ?: $branchApplication->institute_name,
            'email' => $branchApplication->email,
        ]);

        return redirect()->route('super-admin.all-branches')
            ->with('status', 'Branch details updated successfully.');
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

    public function toggleStatus(BranchApplication $branchApplication): RedirectResponse
    {
        Gate::authorize('update', $branchApplication);

        $branchApplication->update(['is_active' => ! $branchApplication->is_active]);

        // Also update the associated user if exists
        \App\Models\User::query()->where('email', $branchApplication->email)->update(['is_active' => $branchApplication->is_active]);

        $statusText = $branchApplication->is_active ? 'Activated' : 'Blocked';

        return back()->with('status', "Branch $statusText successfully.");
    }

    public function destroy(BranchApplication $branchApplication): RedirectResponse
    {
        Gate::authorize('delete', $branchApplication);

        $branchApplication->delete();

        return redirect()->route('super-admin.all-branches')
            ->with('status', 'Branch deleted successfully.');
    }
}
