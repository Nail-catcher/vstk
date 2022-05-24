<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreventiveStore extends FormRequest
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
            'model' => [
                'nullable',
                'required_with:model_id',
                Rule::in(['App\Models\Group', 'App\Models\Sensor'])
            ],
            'model_id' => [
                'nullable',
                'required_with:model',
                Rule::exists($this->model, 'id')
            ],
            'value' => [
                'required',
                'string'
            ],
            'deviation' => [
                'required',
                'string'
            ],
            'progress' => [
                'required',
                Rule::exists('progress', 'id')->where('type_id', 2)
            ],
            'comment' => [
                'nullable',
                'string'
            ]
        ];
    }
}
