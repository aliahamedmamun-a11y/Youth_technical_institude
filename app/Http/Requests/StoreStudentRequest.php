<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Student::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        return [
            'course_id' => ['nullable'],
            'branch_id' => ['nullable', 'string', 'max:255'],
            'director_name' => ['nullable', 'string', 'max:255'],
            'institute_name' => ['nullable', 'string', 'max:255'],
            'certificate_serial' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'roll_number' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'district' => ['nullable', 'string', 'max:255'],
            'upazila' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable'],
            'passport_nid_number' => ['nullable', 'string', 'max:255'],
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
            'admitted_at' => ['nullable'],
            'expire_date' => ['nullable'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'declaration' => ['nullable'],
        ];
    }
}
