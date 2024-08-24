<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'title' => 'required|max:255',
            'summary' => 'required',
            'year' => 'required|date',
            'poster'=> 'mimes:jpg,png,bmp',
            'genre_id' => 'required|exists:genres,id'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'inputan title harus diisi',
            'summary.required' => 'inputan summary harus diisi',
            'year.required' => 'input tahun dengan format yy-mm-dd',
            'poster.mimes' => 'inputan hanya bisa untuk format jpg,png,bmp',
            'genre_id.required' => 'inputan genre harus diisi'
        ];
    }
}
