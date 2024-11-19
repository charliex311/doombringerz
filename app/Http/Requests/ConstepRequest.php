<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConstepRequest extends FormRequest
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
            'sort' => ['max:10', 'numeric'],
            'btn1_title_ru' => ['max:255'],
            'btn1_title_en' => ['max:255'],
            'btn1_title_br' => ['max:255'],
            'btn1_title_es' => ['max:255'],
            'btn1_title_fr' => ['max:255'],
            'btn1_url' => ['max:255'],
            'btn2_title_ru' => ['max:255'],
            'btn2_title_en' => ['max:255'],
            'btn2_title_br' => ['max:255'],
            'btn2_title_es' => ['max:255'],
            'btn2_title_fr' => ['max:255'],
            'btn2_url' => ['max:255'],
            'btn3_title_ru' => ['max:255'],
            'btn3_title_en' => ['max:255'],
            'btn3_title_br' => ['max:255'],
            'btn3_title_es' => ['max:255'],
            'btn3_title_fr' => ['max:255'],
            'btn3_url' => ['max:255'],
            'btn4_title_ru' => ['max:255'],
            'btn4_title_en' => ['max:255'],
            'btn4_title_br' => ['max:255'],
            'btn4_title_es' => ['max:255'],
            'btn4_title_fr' => ['max:255'],
            'btn4_url' => ['max:255'],
        ];
    }
}
