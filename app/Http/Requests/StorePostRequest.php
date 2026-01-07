<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'   => 'required|min:3',
            'content' => 'required',
            'file'    => 'required|image|max:1024',

            // === Categories ===
            'categories'      => 'array',
            'categories.*'    => 'integer|min:1',

            // === Tags ===
            'tags'            => 'array',
            'tags.*'          => 'integer|min:1',
        ];
    }
}
