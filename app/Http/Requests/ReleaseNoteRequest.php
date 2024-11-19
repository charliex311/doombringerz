<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => ['required', 'string', 'max:10'],
            'status' => ['max:1'],
            'title_ru' => ['max:255'],
            'title_en' => ['max:255'],
            'title_br' => ['max:255'],
            'title_es' => ['max:255'],
            'description_ru' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'description_pt' => ['nullable', 'string'],
            'description_es' => ['nullable', 'string'],
            'server' => [''],
            'date' => [''],
        ];
    }
}
