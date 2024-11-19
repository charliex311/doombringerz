<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BazaarItemRequest extends FormRequest
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
            'type' => ['required','max:20'],
            'category_id' => ['required','max:20'],
            'price' => ['required','max:10'],
            'class' => ['required','max:255'],
            'status' => ['required','max:1'],
            'title_ru' => ['max:255'],
            'title_en' => ['required','max:255'],
            'title_br' => ['max:255'],
            'title_es' => ['max:255'],
            'title_fr' => ['max:255'],
            'description_ru' => ['max:255'],
            'description_en' => ['required','max:255'],
            'description_br' => ['max:255'],
            'description_es' => ['max:255'],
            'description_fr' => ['max:255'],
            'image' => ['required_without:edit', 'image'],
        ];
    }
}
