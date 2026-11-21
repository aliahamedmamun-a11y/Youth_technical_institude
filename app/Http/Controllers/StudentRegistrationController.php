<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class StudentRegistrationController extends Controller
{
    public function create(): View
    {
        Gate::authorize('create', Student::class);

        return view('student-registrations.create', [
            'courses' => $this->courses(),
        ]);
    }


    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $studentData = $request->safe()->except('image');

        if (empty($studentData['registration_number'])) {
            $studentData['registration_number'] = $this->registrationNumber();
        }

        if (empty($studentData['roll_number'])) {
            $studentData['roll_number'] = $this->rollNumber();
        }

        $studentData['result_status'] = 'Pending';

        if ($request->user() && $request->user()->hasRole(\App\Enums\UserRole::Branch)) {
            $branch = \App\Models\BranchApplication::query()->where('email', $request->user()->email)->first();
            if ($branch) {
                $studentData['branch_id'] = $studentData['branch_id'] ?? $branch->id;
                $studentData['director_name'] = $studentData['director_name'] ?? $branch->director_name;
            }
        }

        if ($request->hasFile('image')) {
            $studentData['image_path'] = \App\Services\FileUploadService::store($request->file('image'), 'students', 'public');
        }

        Student::query()->create($studentData);

        return redirect()
            ->route('student-registrations.create')
            ->with(
                'status',
                'Your student registration has been submitted successfully.'
            );
    }



    /**
     * Get active courses.
     *
     * @return Collection<int, Course>
     */
    private function courses(): Collection
    {
        return Course::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }



    /**
     * Generate unique registration number.
     */
    private function registrationNumber(): string
    {
        do {
            $registrationNumber = (string) random_int(10000000, 99999999);
        } while (Student::query()->where('registration_number', $registrationNumber)->exists());

        return $registrationNumber;
    }

    /**
     * Generate unique roll number.
     */
    private function rollNumber(): string
    {
        do {
            $rollNumber = (string) random_int(100000, 999999);
        } while (Student::query()->where('roll_number', $rollNumber)->exists());

        return $rollNumber;
    }
}
