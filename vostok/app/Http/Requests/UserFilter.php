<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFilter extends FormRequest
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
            'area' => [
                'nullable',
                'exists:areas,id'
            ],
            'roles' => [
                'nullable',
                'array'
            ],
            'roles.*' => [
                'required',
                Rule::exists('roles', 'id')->whereNull('deleted_at')
            ],
            'positions' => [
                'nullable',
                'array'
            ],
            'positions.*' => [
                'required',
                'integer',
                Rule::exists('positions', 'id')
            ],
            'position' => [
                'nullable',
                'integer',
                Rule::exists('positions', 'id')
            ],
            'email' => [
                'nullable',
                'string',
                'min:3'
            ],
            'phone' => [
                'nullable',
                'string',
                'min:3'
            ],
            'fio' => [
                'nullable',
                'string',
                'min:3'
            ],
            'lastname' => [
                'nullable',
                'string',
                'min:3'
            ]
        ];
    }
}
