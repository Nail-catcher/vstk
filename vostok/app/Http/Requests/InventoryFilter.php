<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryFilter extends FormRequest
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
            'title' => [
                'nullable',
                'string'
            ],
            'rrs' => [
                'nullable',
                'string'
            ],
            'categories' => [
                'nullable',
                'array'
            ],
            'categories.*' => [
                'required',
                'exists:categories,id'
            ],
            'barcode' => [
                'nullable',
                'string'
            ],
            'user' => [
                'nullable',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'division' => [
                'nullable',
                Rule::exists('divisions', 'id')
            ],
            'date_from' => [
                'nullable',
                'date'
            ],
            'date_to' => [
                'nullable',
                'date'
            ]
        ];
    }
}
