<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => [
                'required',
                'max:64',
                'min:3',
                'string',
                Rule::unique('users')
            ],
            'name' => [
                'required',
                'max:32',
                'min:2',
                'string',
            ],
            'surname' => [
                'required',
                'max:64',
                'min:3',
                'string',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'min:3',
                'string',
                Rule::unique('users')
            ],
            'password' => [
                'bail',
                'required',
                'confirmed', // password_confirmation
                'min:3',
                'max:255',
                'string'
            ]
        ];
    }
}
