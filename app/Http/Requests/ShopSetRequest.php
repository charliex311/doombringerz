<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopSetRequest extends FormRequest
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
            'category_id' => ['required','max:20'],
            'price' => ['required','max:10'],
            'status' => ['required','max:1'],
            'items_id' => ['required','max:255'],
            'title_ru' => ['required','max:255'],
            'title_en' => ['required','max:255'],
            'description_ru' => ['required'],
            'description_en' => ['required'],
            'sort' => ['max:10'],
            'purchase_type' => ['max:2'],
            'use_time' => ['max:10'],
            'quantity_type' => ['max:2'],
            'quantity_max' => ['max:20'],
            'image' => ['required_without:edit', 'image'],
        ];
    }
}
