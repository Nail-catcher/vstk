<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgressStart extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
//        $pivot = DB::table('application_station')
//            ->where('application_id', '=', $this->application->id)
//            ->where('station_id', '=', $this->station)
//            ->first();
        $this->merge([
            'starting' => is_null($this->application->starting_id),
//            'complete' => (!is_null($pivot)) ? $pivot->is_complete : true
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'starting' => [
                'required',
                'boolean',
                Rule::in([true])
            ],
//            'complete' => [
//                'required',
//                Rule::in([false])
//            ],
            'station' => [
                'required',
                'integer',
                Rule::exists('stations', 'id')->whereNull('deleted_at'),
                Rule::exists('application_station', 'station_id')->where('application_id', $this->application->id)
            ],
            'comment' => [
                'nullable',
                'string'
            ],
            'type' => [
                'required',
                'exists:progress_types,id'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'starting.in' => 'Пожалуйста, закончите ход работ по предыдущей БС.'
        ];
    }
}
