<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketItemRequest extends FormRequest
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
            'l2_id' => ['required','max:20'],
            'category_id' => ['required','max:20'],
            'price' => ['required','max:10'],
            'class' => ['required','max:255'],
            'status' => ['required','max:1'],
            'title_ru' => ['required','max:255'],
            'title_en' => ['required','max:255'],
            'description_ru' => ['required','max:255'],
            'description_en' => ['required','max:255'],
            'image' => ['required_without:edit', 'image'],
        ];
    }
}
