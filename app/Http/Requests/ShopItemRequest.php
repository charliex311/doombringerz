<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopItemRequest extends FormRequest
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
            'wow_id' => ['max:255'],
            'category_id' => ['max:20'],
            'price' => ['max:10'],
            'sale' =>  ['max:10'],
            'status' => ['max:10'],
            'label' => ['max:2'],
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
            'description_add_ru' => [''],
            'description_add_en' => [''],
            'description_add_be' => [''],
            'description_add_es' => [''],
            'description_add_fr' => [''],
            'image' => ['required_without:edit', 'image'],
            'togethers' => [''],
        ];
    }
}
