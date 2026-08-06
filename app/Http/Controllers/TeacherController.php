<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function show(Teacher $teacher): View
    {
        abort_unless($teacher->is_active, 404);

        return view('teachers.show', [
            'teacher' => $teacher,
            'experience' => $teacher->joined_at ? max(1, (int) $teacher->joined_at->diffInYears(now())) : null,
        ]);
    }
}
