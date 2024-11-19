<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'type' => ['required', 'string'],
            'status' => ['max:1'],
            'title_ru' => ['nullable','max:255', 'string'],
            'title_en' => ['nullable','max:255', 'string'],
            'title_pt' => ['nullable','max:255', 'string'],
            'title_es' => ['nullable','max:255', 'string'],
            'description_ru' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'description_pt' => ['nullable', 'string'],
            'description_es' => ['nullable', 'string'],
            'image' => ['required_without:edit', 'image'],
            'add_image' => ['nullable', 'image']
        ];
    }
}
