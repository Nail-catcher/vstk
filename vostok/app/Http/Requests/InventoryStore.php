<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'inventory' => [
                'sometimes',
                'required',
                Rule::exists('inventories', 'id')->whereNull('deleted_at')
            ],
            'title' => [
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'category' => [
                'nullable',
                'exists:categories,id'
            ],
            'rrs' => [
                'nullable',
                'string',
                'min:3',
                'max:255'
            ],
            'range' => [
                'nullable',
                'string',
                'min:3',
                'max:255'
            ],
            'manufacturer_code' => [
                'nullable',
                'string',
                'min:3',
                'max:255'
            ],
            'serial_number' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'barcode' => [
                'nullable',
                'string',
                'min:3',
                'max:255'
            ],
            'barcode_type' => [
                'nullable',
                'string',
                'min:3',
                'max:255'
            ],

        ];
    }
}
