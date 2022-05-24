<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportOperatorPPRRequest extends FormRequest
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
            'area_id' => ['nullable', 'exists:areas,id'],
            'stations' => ['nullable', 'array'],
            'stations.*' => ['exists:stations,id']
        ];
    }
}
