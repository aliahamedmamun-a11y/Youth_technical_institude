<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;
use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Notice::class);

        return view('super-admin.notices.index', ['notices' => Notice::query()->with('author')->latest('published_at')->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', Notice::class);

        return view('super-admin.notices.create', ['notice' => new Notice(['is_published' => true])]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoticeRequest $request): RedirectResponse
    {
        Gate::authorize('create', Notice::class);
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;
        Notice::query()->create($data);

        return redirect()->route('super-admin.notices.index')->with('status', 'Notice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice): View
    {
        Gate::authorize('update', $notice);

        return view('super-admin.notices.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoticeRequest $request, Notice $notice): RedirectResponse
    {
        Gate::authorize('update', $notice);
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($notice->published_at ?? now()) : null;
        $notice->update($data);

        return redirect()->route('super-admin.notices.index')->with('status', 'Notice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice): RedirectResponse
    {
        Gate::authorize('delete', $notice);
        $notice->delete();

        return back()->with('status', 'Notice deleted successfully.');
    }
}
