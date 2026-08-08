<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomepageItemRequest;
use App\Http\Requests\UpdateHomepageItemRequest;
use App\Models\HomepageItem;
use App\Models\HomepageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomepageContentController extends Controller
{
    public function updateSection(Request $request, HomepageSection $section): RedirectResponse
    {
        Gate::authorize('update', $section);
        $data = $request->validate([
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_visible' => ['nullable', 'boolean'],
        ]);
        $section->update([
            'sort_order' => $data['sort_order'],
            'is_visible' => $request->boolean('is_visible'),
        ]);

        return back()->with('status', 'Homepage section settings updated.');
    }

    public function index(string $section): View
    {
        Gate::authorize('viewAny', HomepageItem::class);
        $homepageSection = HomepageSection::query()->where('key', $section)->firstOrFail();

        return view('super-admin.homepage.index', ['section' => $homepageSection, 'items' => $homepageSection->items()->paginate(15)]);
    }

    public function create(string $section): View
    {
        Gate::authorize('create', HomepageItem::class);
        $homepageSection = HomepageSection::query()->where('key', $section)->firstOrFail();

        return view('super-admin.homepage.create', ['section' => $homepageSection, 'item' => new HomepageItem(['sort_order' => 0, 'is_published' => true])]);
    }

    public function store(StoreHomepageItemRequest $request): RedirectResponse
    {
        Gate::authorize('create', HomepageItem::class);
        $data = $request->validated();
        $section = HomepageSection::query()->where('key', $data['section'])->firstOrFail();
        unset($data['section'], $data['image']);
        $data['homepage_section_id'] = $section->id;
        $data['is_published'] = $request->boolean('is_published');
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('homepage', 'public');
        }
        HomepageItem::query()->create($data);

        return redirect()->route('super-admin.homepage.items.index', $section->key)->with('status', 'Homepage content created successfully.');
    }

    public function edit(HomepageItem $item): View
    {
        Gate::authorize('update', $item);

        return view('super-admin.homepage.edit', ['item' => $item, 'section' => $item->section]);
    }

    public function update(UpdateHomepageItemRequest $request, HomepageItem $item): RedirectResponse
    {
        Gate::authorize('update', $item);
        $data = $request->validated();
        $section = HomepageSection::query()->where('key', $data['section'])->firstOrFail();
        unset($data['section'], $data['image']);
        $data['homepage_section_id'] = $section->id;
        $data['is_published'] = $request->boolean('is_published');
        $previousImage = $item->image_path;
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('homepage', 'public');
        }
        $item->update($data);
        if ($request->hasFile('image') && $previousImage) {
            Storage::disk('public')->delete($previousImage);
        }

        return redirect()->route('super-admin.homepage.items.index', $section->key)->with('status', 'Homepage content updated successfully.');
    }

    public function destroy(HomepageItem $item): RedirectResponse
    {
        Gate::authorize('delete', $item);
        $section = $item->section;
        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }
        $item->delete();

        return redirect()->route('super-admin.homepage.items.index', $section->key)->with('status', 'Homepage content deleted successfully.');
    }
}
