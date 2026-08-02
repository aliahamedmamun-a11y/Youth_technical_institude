<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnrollmentResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['session' => ['required', 'string', 'max:100'], 'status' => ['required', Rule::in(['draft', 'published'])], 'subjects' => ['required', 'array', 'min:1'], 'subjects.*.id' => ['required', 'integer', Rule::exists('student_semester_subjects', 'id')], 'subjects.*.marks' => ['nullable', 'numeric', 'between:0,100']];
    }
}
