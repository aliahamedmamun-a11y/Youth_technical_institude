<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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
            'course_id' => ['required', 'integer', Rule::exists('courses', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'father_name' => ['required', 'string', 'max:255'],
            'mother_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:2000'],
            'district' => ['required', Rule::in(config('bangladesh.districts'))],
            'upazila' => ['required', Rule::in(config('bangladesh.upazilas.'.$this->input('district'), []))],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'passport_nid_number' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:30'],
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'education_qualification' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:100'],
            'session' => ['required', 'string', 'max:100'],
            'admitted_at' => ['required', 'date'],
            'expire_date' => ['required', 'date', 'after:admitted_at'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'declaration' => [Rule::when($this->routeIs('student-registrations.store'), ['required', 'accepted'])],
        ];
    }
}
