<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentResultRequest extends FormRequest
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
            'student_id' => ['required', 'integer', Rule::exists('students', 'id')],
            'semester' => ['required', 'string', 'max:150'],
            'session' => ['required', 'string', 'max:100'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*.code' => ['required', 'string', 'max:30', 'distinct'],
            'subjects.*.title' => ['required', 'string', 'max:255'],
            'subjects.*.credit' => ['required', 'numeric', 'between:0.5,20'],
            'subjects.*.marks' => ['nullable', 'numeric', 'between:0,100'],
            'subjects.*.grade' => ['required', 'string', 'max:10'],
            'subjects.*.grade_point' => ['required', 'numeric', 'between:0,4'],
        ];
    }
}
