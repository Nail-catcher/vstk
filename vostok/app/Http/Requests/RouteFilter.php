<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteFilter extends FormRequest
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
            'limit' => ['nullable', 'numeric'],
            'areas' => [
                'nullable',
                'array'
            ],
            'areas.*' => [
                'required',
                'exists:areas,id'
            ],
            'states' => [
                'nullable',
                'array'
            ],
            'states.*' => [
                'required',
                'exists:states,id'
            ]

        ];
    }
}
