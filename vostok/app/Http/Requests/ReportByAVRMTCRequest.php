<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportByAVRMTCRequest extends FormRequest
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
            'start' => [
                'required',
                'date'
            ],
            'end' => [
                'required',
                'date'
            ],
            'stations' => ['nullable', 'array'],
            'area_id' => ['nullable', 'integer']
        ];
    }
}
