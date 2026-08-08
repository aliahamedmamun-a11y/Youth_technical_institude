<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHomepageItemRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return ['section' => ['required', 'exists:homepage_sections,key'], 'stable_key' => ['required', 'string', 'max:100'], 'title' => ['nullable', 'string', 'max:255'], 'subtitle' => ['nullable', 'string', 'max:255'], 'body' => ['nullable', 'string', 'max:5000'], 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:25600'], 'icon' => ['nullable', 'string', 'max:100'], 'link_label' => ['nullable', 'string', 'max:100'], 'link_url' => ['nullable', 'string', 'max:2048'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_published' => ['boolean'], 'metadata' => ['nullable', 'array']];
    }
}
