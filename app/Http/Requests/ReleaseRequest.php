<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseRequest extends FormRequest
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
            'title_ru'        => ['max:255'],
            'title_en'        => ['max:255'],
            'title_br'        => ['max:255'],
            'title_es'        => ['max:255'],
            'title_fr'        => ['max:255'],
            'description_ru'  => [''],
            'description_en'  => [''],
            'description_be'  => [''],
            'description_es'  => [''],
            'description_fr'  => [''],
            'url_ru'          => ['max:255', 'string'],
            'url_en'          => ['max:255', 'string'],
            'url_br'          => ['max:255', 'string'],
            'url_es'          => ['max:255', 'string'],
            'is_release'      => ['max:1', 'string'],
            'link'            => ['max:255', 'string'],
            'date'            => [''],
            'sort'            => ['max:10', 'numeric'],
            'category'        => ['max:10', 'numeric'],
            'expected_result' => ['nullable', 'string'],
            'image'           => ['required_without:edit', 'image'],
        ];
    }
}
