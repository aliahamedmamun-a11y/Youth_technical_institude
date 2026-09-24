<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        return [
            'branch_id' => ['nullable', 'string', 'max:255'],
            'course_id' => ['nullable', 'integer'],
            'name' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:255'],
            'roll_number' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'district' => ['nullable', 'string', 'max:255'],
            'upazila' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'passport_nid_number' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'string', 'max:50'],
            'religion' => ['nullable', 'string', 'max:50'],
            'start_month' => ['nullable', 'string', 'max:50'],
            'start_year' => ['nullable', 'string', 'max:10'],
            'end_month' => ['nullable', 'string', 'max:50'],
            'end_year' => ['nullable', 'string', 'max:10'],
            'education_qualification' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:100'],
            'session' => ['nullable', 'string', 'max:100'],
            'admitted_at' => ['nullable', 'date'],
            'expire_date' => ['nullable', 'date'],
            'director_name' => ['nullable', 'string', 'max:255'],
            'full_marks' => ['nullable', 'numeric'],
            'written_marks' => ['nullable', 'numeric'],
            'viva_marks' => ['nullable', 'numeric'],
            'practical_marks' => ['nullable', 'numeric'],
            'score' => ['nullable', 'numeric'],
            'grade' => ['nullable', 'string', 'max:50'],
            'cgpa' => ['nullable', 'numeric'],
            'publication_date' => ['nullable', 'string', 'max:255'],
            'examination_month' => ['nullable', 'string', 'max:255'],
            'result_status' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
