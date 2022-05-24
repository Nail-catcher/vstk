<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MeasurementStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'counter_number' => [
                'required',
                'string',
                'min:5',
                'max:255'
            ],
            'phase_1' => [
                'required',
                'numeric'
            ],
            'phase_2' => [
                'required',
                'numeric'
            ],
            'phase_3' => [
                'nullable',
                'numeric'
            ],
            'images' => [
                'nullable',
                'array',
                'min:1'
            ],
            'images.*' => [
                'required',
                Rule::exists('images', 'id')->whereNull('deleted_at')
                    ->whereNull('attached_at')
                    ->where('imageable_type', 'App\Models\Application')
                    ->where('imageable_id', $this->application->id)
            ],
        ];
    }
}
