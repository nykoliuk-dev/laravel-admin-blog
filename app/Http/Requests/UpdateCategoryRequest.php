<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|min:4|unique:categories,name,' . $this->route('category') . ',slug',
            'parent_id'     => 'nullable|exists:categories,id',
            'editSlug'      => 'bool',
            'slug'          => 'required_if:editSlug,1|nullable|regex:/^[a-z0-9-]+$/|max:255',
        ];
    }
}
