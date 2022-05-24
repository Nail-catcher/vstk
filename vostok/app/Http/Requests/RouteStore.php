<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RouteStore extends FormRequest
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
            'consumables' => [
                'nullable',
                'array',
            ],
            'consumables.*.id' => [
                'nullable',
                Rule::exists('consumables', 'id')->whereNull('deleted_at')
            ],
            'consumables.*.count' => [
                'nullable',
                'integer',
            ],
            'applications' => [
                'required',
                'array',
                'min:1'
            ],
            'applications.*' => [
                'required',
                Rule::exists('applications', 'id')->whereNull('deleted_at')
            ],
            'engineer' => [
                'sometimes',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'addresses' => [
                'nullable',
                'array'
            ],
            'addresses.*' => [
                'required',
                'exists:addresses,id'
            ],
            'places' => [
                'nullable',
                'array'
            ],
            'places.*' => [
                'required',
                'exists:places,id'
            ],
            'area' => [
                'required',
                'exists:areas,id'
            ],
            'vehicle_type' => [
                'nullable',
                'exists:vehicle_types,id'
            ],
            'vehicle' => [
                'nullable',
                'exists:vehicles,id'
            ],
            'started_at' => [
                'required',
                'date'
            ],
            'deadline_at' => [
                'required',
                'date'
            ]
        ];
    }
}
