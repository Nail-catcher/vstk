<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StationFilter extends FormRequest
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
            'state' => [
                'nullable',
                Rule::exists('states', 'id')
            ],
            'area' => [
                'nullable',
                'exists:areas,id'
            ],
            'project' => [
                'nullable',
                'exists:projects,id'
            ],
            'bts_id' => [
                'nullable',
                'string',
                'max:255'
            ]
        ];
    }
}
