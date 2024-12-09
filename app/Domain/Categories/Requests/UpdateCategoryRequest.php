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
            'file_id' => 'sometimes|exists:files,id|required_without:file', // file bo'lmasa kerakli bo'ladi
            'file' => 'sometimes|file|mimes:png,jpeg,jpg|max:1536|required_without:file_id', // file_id bo'lmasa kerakli bo'ladi

            'uz' => 'string|required',
            'ru' => 'string|sometimes',
            'en' => 'string|sometimes',
        ];
    }
}
