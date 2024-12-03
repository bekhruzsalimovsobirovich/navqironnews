<?php

namespace App\Domain\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCategoryRequest extends FormRequest
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
            'uz' => 'array|required',
            'uz.name' => 'required|string',

            'ru' => 'array|sometimes',
            'ru.name' => 'sometimes|string',

            'en' => 'array|sometimes',
            'en.name' => 'sometimes|string',
        ];
    }
}
