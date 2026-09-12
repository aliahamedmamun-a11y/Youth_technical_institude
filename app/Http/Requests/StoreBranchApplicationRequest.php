<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBranchApplicationRequest extends FormRequest
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
            'director_name' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'institute_name' => ['nullable', 'string', 'max:255'],
            'full_address' => ['nullable', 'string', 'max:2000'],
            'district' => ['nullable', Rule::in(config('bangladesh.districts'))],
            'upazila' => ['nullable', Rule::in(config('bangladesh.upazilas.'.$this->input('district'), []))],
            'post_office' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'sex' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'username' => ['required', 'string', 'alpha_dash', 'min:4', 'max:50', Rule::unique('branch_applications', 'username')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile_number' => ['nullable', 'string', 'max:30'],
            'director_signature' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'nid_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'director_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'institute_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
