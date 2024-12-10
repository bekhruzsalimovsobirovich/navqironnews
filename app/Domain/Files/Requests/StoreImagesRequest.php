<?php

namespace App\Domain\Files\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'data' => ['array','required'],
            'data.*.file' => ['required','file','max:10240','mimes:jpg,png,jpeg']
        ];
    }
}
