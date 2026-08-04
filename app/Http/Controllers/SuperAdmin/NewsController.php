<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', News::class);

        return view('super-admin.news.index', ['news' => News::query()->with('author')->latest()->paginate(15)]);
    }

    public function create(): View
    {
        Gate::authorize('create', News::class);

        return view('super-admin.news.create', ['news' => new News]);
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        Gate::authorize('create', News::class);
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news', 'public');
        } News::create($data);

        return redirect()->route('super-admin.news.index')->with('status', 'News created successfully.');
    }

    public function edit(News $news): View
    {
        Gate::authorize('update', $news);

        return view('super-admin.news.edit', compact('news'));
    }

    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        Gate::authorize('update', $news);
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($news->published_at ?? now()) : null;
        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            } $data['image_path'] = $request->file('image')->store('news', 'public');
        } $news->update($data);

        return redirect()->route('super-admin.news.index')->with('status', 'News updated successfully.');
    }

    public function destroy(News $news): RedirectResponse
    {
        Gate::authorize('delete', $news);
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        } $news->delete();

        return back()->with('status', 'News deleted successfully.');
    }
}
