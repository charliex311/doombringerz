<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketCategoryRequest extends FormRequest
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
            'path' => ['required','max:255'],
            'title_ru' => ['max:255'],
            'title_en' => ['max:255'],
            'title_pt' => ['max:255'],
            'title_es' => ['max:255'],
            'description_ru' => ['max:255'],
            'description_en' => ['max:255'],
            'description_pt' => ['max:255'],
            'description_es' => ['max:255'],
            'sort' => ['max:10'],
            'image' => ['required_without:edit', 'image'],
        ];
    }
}
