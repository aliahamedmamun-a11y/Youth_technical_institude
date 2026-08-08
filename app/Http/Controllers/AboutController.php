<?php

namespace App\Http\Controllers;

use App\Models\InstituteProfile;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function show(InstituteProfile $about): View
    {
        abort_unless($about->is_active && $about->is_published, 404);

        return view('about.show', compact('about'));
    }
}
