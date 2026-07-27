<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        return redirect()->route($request->user()->role->dashboardRoute());
    }

    public function superAdmin(): View
    {
        return view('dashboards.super-admin');
    }

    public function branch(): View
    {
        return view('dashboards.branch');
    }

    public function editor(): View
    {
        return view('dashboards.editor');
    }

    public function student(): View
    {
        return view('dashboards.student');
    }
}
