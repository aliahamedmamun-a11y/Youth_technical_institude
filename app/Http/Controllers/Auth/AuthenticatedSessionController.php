<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials['is_active'] = true;

        // Automatically fix legacy plain text passwords in the database if necessary
        $existingUser = \App\Models\User::query()->where('email', $request->email)->first();
        if ($existingUser && $existingUser->password && ! str_starts_with($existingUser->password, '$2y$') && ! str_starts_with($existingUser->password, '$2a$') && ! str_starts_with($existingUser->password, '$2b$')) {
            if ($existingUser->password === $request->password) {
                $existingUser->password = $request->password;
                $existingUser->save();
            }
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // Check if user exists but is blocked
            if (\App\Models\User::query()->where('email', $request->email)->where('is_active', false)->exists()) {
                return back()
                    ->withErrors(['email' => 'Your account has been blocked. Please contact the administrator.'])
                    ->onlyInput('email');
            }

            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route($request->user()->role->dashboardRoute(), absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
