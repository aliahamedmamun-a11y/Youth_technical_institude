<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'proposed_branch_name' => ['required', 'string', 'max:255'], 'applicant_name' => ['required', 'string', 'max:255'], 'email' => ['required', 'email', 'max:255'], 'phone' => ['required', 'string', 'max:30'], 'district' => ['required', 'string', 'max:255'], 'address' => ['required', 'string', 'max:2000'], 'years_of_experience' => ['nullable', 'integer', 'min:0', 'max:80'], 'message' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
