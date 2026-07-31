<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['code' => ['required', 'string', 'max:30', Rule::unique('subjects', 'code')->where(fn ($query) => $query->where('semester_id', $this->route('semester')->id))->ignore($this->route('subject')->id)], 'title' => ['required', 'string', 'max:255'], 'credit' => ['required', 'numeric', 'between:0.5,20'], 'sort_order' => ['required', 'integer', 'min:0', 'max:999'], 'is_active' => ['boolean']];
    }
}
