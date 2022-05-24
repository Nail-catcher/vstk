<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportWorkdoneRequest extends FormRequest
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
            'application_id' => ['required'],
            'area_id' => ['nullable'],
            'stations' => ['nullable', 'array'],
            'stations.*' => ['exists:stations,id']
        ];
    }
}
