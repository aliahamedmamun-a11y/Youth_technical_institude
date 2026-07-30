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
            'director_name' => ['required', 'string', 'max:255'], 'father_name' => ['required', 'string', 'max:255'], 'mother_name' => ['required', 'string', 'max:255'], 'institute_name' => ['required', 'string', 'max:255'], 'full_address' => ['required', 'string', 'max:2000'], 'district' => ['required', Rule::in(config('bangladesh.districts'))], 'upazila' => ['required', Rule::in(config('bangladesh.upazilas.'.$this->input('district'), []))], 'post_office' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'max:255'], 'sex' => ['required', Rule::in(['Male', 'Female', 'Other'])], 'username' => ['required', 'string', 'alpha_dash', 'min:4', 'max:50', Rule::unique('branch_applications', 'username')], 'password' => ['required', 'string', 'min:8', 'confirmed'], 'mobile_number' => ['required', 'string', 'max:30'], 'director_signature' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], 'nid_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'], 'director_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
