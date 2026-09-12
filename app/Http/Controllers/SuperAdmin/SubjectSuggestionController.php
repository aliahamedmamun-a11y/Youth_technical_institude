<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubjectSuggestion;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SubjectSuggestionController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $suggestions = SubjectSuggestion::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->get();

        return view('super-admin.subject-suggestions.index', compact('suggestions', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        SubjectSuggestion::create($validated);

        return back()->with('status', 'Subject suggestion added successfully.');
    }

    public function destroy(SubjectSuggestion $suggestion): RedirectResponse
    {
        $suggestion->delete();

        return back()->with('status', 'Subject suggestion deleted.');
    }
}
