<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefectiveStoreRequest extends FormRequest
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
            'title' => [
                'required',
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
            'inventory_number' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'comment' => [
                'required',
                'string'
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
