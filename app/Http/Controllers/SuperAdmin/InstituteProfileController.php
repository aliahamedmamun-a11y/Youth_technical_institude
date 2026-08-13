<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstituteProfileRequest;
use App\Http\Requests\UpdateInstituteProfileEntryRequest;
use App\Models\InstituteProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstituteProfileController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', InstituteProfile::class);

        $search = $request->string('search')->trim()->toString();
        $status = $request->string('status')->toString();

        return view('super-admin.about.index', [
            'abouts' => InstituteProfile::query()->when($search, fn ($query) => $query->where('about_heading', 'like', "%{$search}%"))->when(in_array($status, ['published', 'draft'], true), fn ($query) => $query->where('is_published', $status === 'published'))->ordered()->paginate(15)->withQueryString(),
            'search' => $search,
            'selectedStatus' => $status,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', InstituteProfile::class);

        return view('super-admin.about.create', ['about' => new InstituteProfile(['sort_order' => 0, 'is_published' => true])]);
    }

    public function store(StoreInstituteProfileRequest $request): RedirectResponse
    {
        Gate::authorize('create', InstituteProfile::class);

        $data = $request->safe()->except('image');
        $data['slug'] = $data['slug'] ?? Str::slug($data['about_heading']);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('about', 'public');
        }

        InstituteProfile::query()->create($data);

        return redirect()->route('super-admin.about.index')->with('status', 'About entry created successfully.');
    }

    public function edit(InstituteProfile $about): View
    {
        Gate::authorize('update', $about);

        return view('super-admin.about.edit', compact('about'));
    }

    public function update(UpdateInstituteProfileEntryRequest $request, InstituteProfile $about): RedirectResponse
    {
        Gate::authorize('update', $about);

        $data = $request->safe()->except('image');
        $data['slug'] = $data['slug'] ?? Str::slug($data['about_heading']);
        $data['is_published'] = $request->boolean('is_published');
        $previousImagePath = $about->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('about', 'public');
        }

        $about->update($data);

        if ($request->hasFile('image') && $previousImagePath) {
            Storage::disk('public')->delete($previousImagePath);
        }

        return redirect()->route('super-admin.about.index')->with('status', 'About entry updated successfully.');
    }

    public function destroy(InstituteProfile $about): RedirectResponse
    {
        Gate::authorize('delete', $about);
        $imagePath = $about->image_path;
        $about->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return back()->with('status', 'About entry deleted successfully.');
    }

    public function togglePublish(InstituteProfile $about): RedirectResponse
    {
        Gate::authorize('update', $about);
        $about->update(['is_published' => ! $about->is_published]);

        return back()->with('status', 'About entry publication status updated.');
    }
}
