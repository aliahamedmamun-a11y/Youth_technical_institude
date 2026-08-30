<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SuperAdmin\StudentDocumentController;
use App\Models\Student;
use App\Services\QrCodeService;
use App\Services\ResultGradingService;
use App\Services\ResultQrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchStudentController extends Controller
{
    /**
     * Display students list with search.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $students = Student::query()
            ->with('course')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('registration_number', 'like', '%' . $search . '%')
                        ->orWhere('roll_number', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        return view('students.index', [
            'students' => $students,
            'search' => $search,
        ]);
    }


    /**
     * Display student registration details.
     */
    public function show(Student $student): View
    {
        $student->load('course');

        return view('students.show', [
            'student' => $student,
        ]);
    }


    /**
     * Show student edit form.
     */
    public function edit(Student $student): View
    {
        $student->load('course');

        return view('students.edit', [
            'student' => $student,
        ]);
    }


    /**
     * Update student information.
     */
    public function update(Request $request, Student $student): RedirectResponse
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'father_name' => ['nullable', 'string', 'max:255'],
        'mother_name' => ['nullable', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:50'],
        'email' => ['nullable', 'email', 'max:255'],
        'gender' => ['nullable', 'string', 'max:50'],
        'date_of_birth' => ['nullable', 'date'],
        'address' => ['nullable', 'string'],
        'district' => ['nullable', 'string', 'max:255'],
        'upazila' => ['nullable', 'string', 'max:255'],
        'passport_nid_number' => ['nullable', 'string', 'max:255'],
        'education_qualification' => ['nullable', 'string', 'max:255'],

        'start_month' => ['nullable', 'string', 'max:50'],
        'end_month' => ['nullable', 'string', 'max:50'],
        'start_year' => ['nullable', 'string', 'max:10'],
        'end_year' => ['nullable', 'string', 'max:10'],

        'session' => ['nullable', 'string', 'max:255'],
        'roll_number' => ['nullable', 'string', 'max:255'],
        'admitted_at' => ['nullable', 'date'],
        'expire_date' => ['nullable', 'date'],
        'result_status' => ['nullable', 'string', 'max:255'],
        'grade' => ['nullable', 'string', 'max:50'],
        'score' => ['nullable', 'numeric'],
    ]);

    $student->update($validated);

    return redirect()
        ->route('students.index')
        ->with('status', 'Student information updated successfully.');
}


    /**
     * Display student documents.
     */
    public function document(
        Student $student,
        string $document,
        ResultGradingService $grading,
        ResultQrCodeService $resultQrCode,
        QrCodeService $qrCode,
        StudentDocumentController $documentController
    ): View|RedirectResponse {

        $allowedDocuments = [
            'admit-card',
            'registration-card',
            'student-id',
            'certificate',
            'testimonial',
            'transcript',
            'forwarding-letter',
            'results',
        ];

        abort_unless(
            in_array($document, $allowedDocuments, true),
            404
        );

        return $documentController->show(
            $student,
            $document,
            $grading,
            $resultQrCode,
            $qrCode
        );
    }
}