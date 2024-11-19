<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'url' => ['required', 'string'],
            'language' => ['required'],
            'image' => ['nullable', 'image'],
            'sort' => ['nullable', 'string']
        ];
    }
}
