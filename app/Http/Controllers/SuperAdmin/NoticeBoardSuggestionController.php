<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\NoticeBoardSuggestion;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class NoticeBoardSuggestionController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $suggestions = NoticeBoardSuggestion::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('suggestion', 'like', "%{$search}%"))
            ->latest()
            ->get();

        return view('super-admin.notices.board-push', compact('suggestions', 'search'));
    }

    public function allTablePost(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $suggestions = NoticeBoardSuggestion::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('suggestion', 'like', "%{$search}%"))
            ->latest()
            ->get();

        return view('super-admin.notices.all-table-post', compact('suggestions', 'search'));
    }

    public function create(): View
    {
        return view('super-admin.notices.board-add');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'suggestion' => 'required|string|max:2000',
        ]);

        NoticeBoardSuggestion::create($validated);

        return back()->with('status', 'Suggestion added to notice board successfully!');
    }
}
