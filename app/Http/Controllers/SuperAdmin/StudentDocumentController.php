<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class StudentDocumentController extends Controller
{
    /** @var array<string, string> */
    private const DOCUMENTS = [
        'admit-card' => 'Admit Card',
        'registration-card' => 'Registration Card',
        'student-id' => 'Student ID Card',
        'certificate' => 'Certificate',
        'testimonial' => 'Testimonial',
        'transcript' => 'Transcript',
        'forwarding-letter' => 'Forwarding Letter',
        'results' => 'Results',
    ];

    public function show(Student $student, string $document): View|RedirectResponse
    {
        Gate::authorize('view', $student);

        abort_unless(array_key_exists($document, self::DOCUMENTS), 404);

        if ($document === 'results') {
            $result = $student->results()->latest('published_at')->first();

            if ($result) {
                return redirect()->route('super-admin.results.show', $result);
            }
        }

        return view('super-admin.students.document', [
            'student' => $student->load('course'),
            'document' => $document,
            'documentTitle' => self::DOCUMENTS[$document],
        ]);
    }
}
