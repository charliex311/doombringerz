<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServerRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'ip' => ['required', 'string'],
            'status' => ['required', 'string'],
            'wowword_db_type' => ['required', 'string'],
            'wowdb_host' => ['required', 'string'],
            'wowdb_port' => ['required', 'string'],
            'wowdb_database' => ['required', 'string'],
            'wowdb_username' => ['required', 'string'],
            'wowdb_password' => ['string'],
            'wowworld_host' => ['required', 'string'],
            'wowworld_port' => ['required', 'string'],
            'wowworld_database' => ['required', 'string'],
            'wowworld_username' => ['required', 'string'],
            'wowworld_password' => ['string'],
            'soap_uri' => ['required', 'string'],
            'soap_login' => ['required', 'string'],
            'soap_password' => ['required', 'string'],
            'soap_style' => ['required', 'string'],
        ];
    }
}
