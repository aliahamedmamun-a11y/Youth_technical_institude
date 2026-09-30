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
        $messages = BranchMessage::latest()->get();

        if ($messages->isEmpty()) {
            $messages = \App\Models\Notice::query()->published()->latest()->get()->map(function ($notice) {
                return (object) [
                    'id' => $notice->id,
                    'name' => $notice->title,
                    'message' => $notice->message,
                    'link' => $notice->link,
                    'created_at' => $notice->created_at ?: now(),
                ];
            });
        }

        return view('super-admin.branch-messages.board', compact('messages'));
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

    public function contactAdmin(): View
    {
        return view('super-admin.branch-messages.contact-admin');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
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
