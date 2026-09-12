<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdminCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminCardController extends Controller
{
    public function index(): View
    {
        $cards = AdminCard::latest()->get();
        return view('super-admin.admin-cards.index', compact('cards'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'items' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('admin-cards', 'public');
        }

        AdminCard::create($validated);

        return back()->with('status', 'Card added successfully.');
    }

    public function edit(AdminCard $adminCard): View
    {
        return view('super-admin.admin-cards.edit', compact('adminCard'));
    }

    public function update(Request $request, AdminCard $adminCard): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'items' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            if ($adminCard->image_path) {
                Storage::disk('public')->delete($adminCard->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('admin-cards', 'public');
        }

        $adminCard->update($validated);

        return redirect()->route('super-admin.admin-cards.index')->with('status', 'Card updated successfully.');
    }

    public function destroy(AdminCard $adminCard): RedirectResponse
    {
        if ($adminCard->image_path) {
            Storage::disk('public')->delete($adminCard->image_path);
        }
        $adminCard->delete();

        return back()->with('status', 'Card deleted successfully.');
    }
}
