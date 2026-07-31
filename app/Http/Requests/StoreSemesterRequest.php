<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSemesterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['course_id' => ['required', 'integer', Rule::exists('courses', 'id')], 'name' => ['required', 'string', 'max:150', Rule::unique('semesters', 'name')->where(fn ($query) => $query->where('course_id', $this->route('course')->id))], 'sort_order' => ['required', 'integer', 'min:0', 'max:999'], 'is_active' => ['boolean']];
    }
}
