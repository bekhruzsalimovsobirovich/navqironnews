<?php

namespace App\Domain\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('administrator');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => 'sometimes|exists:categories,id',
            'category' => 'sometimes|json',
            'file' => 'sometimes|file|max:10240|mimes:jpg,png,jpeg',

            'uz' => 'string|required',
            'ru' => 'string|sometimes',
            'en' => 'string|sometimes',
        ];
    }
}
