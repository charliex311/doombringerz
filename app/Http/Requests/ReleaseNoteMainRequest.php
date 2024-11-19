<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseNoteMainRequest extends FormRequest
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
            'title_en' => ['required', 'string', 'max:255'],
            'server' => ['required', 'string', 'max:10'],
            'category_id' => ['required', 'string', 'max:5'],
            'description_en' => ['required', 'string'],
        ];
    }
}
