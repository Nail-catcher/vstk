<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProtocolStoreRequest extends FormRequest
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
            'battery' => [
                'required',
                Rule::exists('batteries', 'id')
                    ->whereNull('deleted_at')
                    ->where('group_id', $this->group)
            ],
            'group' => [
                'required',
                Rule::exists('groups', 'id')
                    ->whereNull('deleted_at')
            ],
            'type' => [
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
            'rated_capacity' => [
                'required',
                'numeric'
            ],
            'rated_voltage' => [
                'required',
                'numeric'
            ],
            'rated_number' => [
                'required',
                'numeric'
            ],
            'capacity' => [
                'required',
                'numeric'
            ],
            'allowable_capacity' => [
                'required',
                'numeric'
            ],
            'discharge_time_0' => [
                'required',
                'numeric'
            ],
            'discharge_time_30' => [
                'required',
                'numeric'
            ],
            'discharge_time_60' => [
                'required',
                'numeric'
            ],
            'discharge_time_90' => [
                'required',
                'numeric'
            ],
            'discharge_time_120' => [
                'required',
                'numeric'
            ],
            'discharge_time_150' => [
                'required',
                'numeric'
            ],
            'discharge_time_180' => [
                'required',

            ],
            'discharge_time_210' => [
                'required',
                'numeric'
            ],
            'discharge_time_240' => [
                'required',
                'numeric'
            ],
            'discharge_time_270' => [
                'required',
                'numeric'
            ],
            'discharge_time_300' => [
                'required',
                'numeric'
            ],
            'discharge_time_330' => [
                'required',
                'numeric'
            ],
            'discharge_time_360' => [
                'required',
                'numeric'
            ],
            'discharge_time_390' => [
                'required',
                'numeric'
            ],
            'discharge_time_420' => [
                'required',
                'numeric'
            ],
            'discharge_time_450' => [
                'required',
                'numeric'
            ],
            'discharge_time_480' => [
                'required',
                'numeric'
            ],
            'device' => [
                'required',
                'string',
                'min:3'
            ]
        ];
    }
}
