<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\BranchMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BranchMessageController extends Controller
{
    public function index(): View
    {
        $messages = BranchMessage::latest()->get();
        return view('super-admin.branch-messages.index', compact('messages'));
    }

    public function board(): View
    {
        return view('super-admin.branch-messages.board');
    }

    public function messagingAdd(): View
    {
        $messages = BranchMessage::latest()->get();
        return view('super-admin.branch-messages.messaging-add', compact('messages'));
    }

    public function allTableAdd(): View
    {
        return view('super-admin.branch-messages.all-table-add');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        BranchMessage::create($validated);

        return back()->with('status', 'Suggestion submitted successfully!');
    }

    public function destroy(BranchMessage $branchMessage): RedirectResponse
    {
        $branchMessage->delete();
        return back()->with('status', 'Message deleted successfully.');
    }
}
