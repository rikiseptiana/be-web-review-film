<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CastRequest extends FormRequest
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
           'name' => 'required|max:255',
           'age' => 'required|max:255',
           'bio' => 'required|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'inputan name harus diisi',
            'name.max' => 'inputan name harus maksimal 255 karakter',
            'age.required' => 'inputan age harus diisi',
            'age.max' => 'inputan age harus maksimal 255 karakter',
            'bio.required' => 'inputan bio harus diisi',
            'bio.max' => 'inputan bio harus maksimal 255 karakter',
        ];
    }
}
