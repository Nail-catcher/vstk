<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteLocationStore extends FormRequest
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
            'locations' => [
                'required',
                'array',
                'min:1'
            ],
            'locations.*.0' => [
                'required',
                'numeric',
                'min:-90',
                'max:90'

            ],
            'locations.*.1' => [
                'required',
                'numeric',
                'min:-180',
                'max:180'
            ]
        ];
    }
}
