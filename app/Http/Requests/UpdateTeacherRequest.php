<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'], 'employee_number' => ['required', 'string', 'max:50', Rule::unique('teachers', 'employee_number')->ignore($this->route('teacher'))], 'email' => ['nullable', 'email', 'max:255', Rule::unique('teachers', 'email')->ignore($this->route('teacher'))], 'phone' => ['required', 'string', 'max:30'], 'designation' => ['required', 'string', 'max:255'], 'department' => ['nullable', 'string', 'max:255'], 'qualification' => ['nullable', 'string', 'max:255'], 'description' => ['nullable', 'string', 'max:2000'], 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], 'joined_at' => ['nullable', 'date'], 'is_active' => ['required', 'boolean'],
        ];
    }
}
