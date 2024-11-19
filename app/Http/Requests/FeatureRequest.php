<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
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
            'status' => ['max:1'],
            'sort' => ['max:10'],
            'link' => ['max:255'],
            'title_ru' => ['max:255'],
            'title_en' => ['max:255'],
            'title_br' => ['max:255'],
            'title_es' => ['max:255'],
            'title_fr' => ['max:255'],
            'description_ru' => [''],
            'description_en' => [''],
            'description_be' => [''],
            'description_es' => [''],
            'description_fr' => [''],
            'image' => ['required_without:edit', 'image'],
        ];
    }
}
