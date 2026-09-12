<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'course_id' => ['nullable', 'integer', Rule::exists('courses', 'id')],
            'name' => ['nullable', 'string', 'max:255'],
            'roll_number' => ['nullable', 'string', 'digits:6', Rule::unique('students', 'roll_number')],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'district' => ['nullable', Rule::in(config('bangladesh.districts'))],
            'upazila' => ['nullable', Rule::in(config('bangladesh.upazilas.'.$this->input('district'), []))],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'passport_nid_number' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'end_month' => ['nullable', 'string', 'max:20'],
            'end_year' => ['nullable', 'string', 'max:10'],
            'education_qualification' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:100'],
            'session' => ['nullable', 'string', 'max:100'],
            'admitted_at' => ['nullable', 'date'],
            'expire_date' => ['nullable', 'date', 'after:admitted_at'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'declaration' => [Rule::when($this->routeIs('student-registrations.store'), ['nullable', 'accepted'])],
        ];
    }
}
