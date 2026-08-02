<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentSemesterEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student');

        return ['semester_id' => ['required', 'integer', Rule::exists('semesters', 'id'), Rule::unique('student_semester_enrollments', 'semester_id')->where(fn ($query) => $query->where('student_id', $student->id))], 'subjects' => ['required', 'array', 'min:1'], 'subjects.*' => ['required', 'integer', Rule::exists('subjects', 'id')]];
    }
}
