<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentRegistrationController extends Controller
{
    public function create(): View
    {
        return view('student-registrations.create', ['courses' => $this->courses()]);
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $studentData = $request->safe()->except('image');
        $studentData['registration_number'] = $this->registrationNumber();
        $studentData['result_status'] = 'Pending';
        $studentData['image_path'] = $request->file('image')->store('students', 'public');

        Student::query()->create($studentData);

        return redirect()->route('student-registrations.create')->with('status', 'Your student registration has been submitted successfully.');
    }

    /** @return Collection<int, Course> */
    private function courses(): Collection
    {
        return Course::query()->where('is_active', true)->orderBy('name')->get();
    }

    private function registrationNumber(): string
    {
        do {
            $registrationNumber = 'BNYTI-'.now()->format('YmdHis').'-'.random_int(100, 999);
        } while (Student::query()->where('registration_number', $registrationNumber)->exists());

        return $registrationNumber;
    }
}
