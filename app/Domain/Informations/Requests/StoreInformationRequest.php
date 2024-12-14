<?php

namespace App\Domain\Informations\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInformationRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',

            'tags' => ['sometimes','array'],
            'tags.*.name' => ['sometimes','string'],

            'uz' => 'array|required',
            'uz.title' => 'required|string',
            'uz.text' => 'required|string',

            'ru' => 'array|sometimes',
            'ru.title' => 'sometimes|string',
            'ru.text' => 'sometimes|string',

            'en' => 'array|sometimes',
            'en.title' => 'sometimes|string',
            'en.text' => 'sometimes|string',
        ];
    }
}
