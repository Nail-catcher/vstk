<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActEquipmentInstallationRequest extends FormRequest
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
            'stations' => ['nullable', 'array'],
            'area_id' => ['nullable', 'integer'],
            'application_id' => ['nullable', 'exists:applications,id']
        ];
    }
}
