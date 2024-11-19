<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'server' => ['required', 'string', 'max:10'],
            'category_id' => ['required', 'string', 'max:5'],
            'subcategory_id' => ['nullable', 'string', 'max:5'],
            'comment' => ['nullable', 'string'],
            'link' => ['nullable', 'string', 'max:255'],
            'question' => ['required', 'string'],
            'expected_result' => ['required', 'string'],
            'attachment' => ['nullable', 'mimetypes:image/*,video/*', 'not_regex:/\.svg$/'],
            'step' => [''],
            'ok' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'ok.required' => __('Нужно принять правила!'),
            'title.required' => __('Укажите тему вашего обращения!'),
            'question.required' => __('Введите текст вашего вопроса!'),
        ];
    }
}
