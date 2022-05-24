<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RouteUpdate extends FormRequest
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
            'started_at' => [
                'nullable',
                'date'
            ],
            'deadline_at' => [
                'nullable',
                'date'
            ],
            'engineer' => [
                'nullable',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'applications' => [
                'nullable',
                'array'
            ],
            'applications.*.application_id' => [
                'required',
                Rule::exists('applications', 'id')->whereNull('deleted_at')
            ],
            'applications.*.sort' => [
                'required',
                'numeric',
                'min:1'
            ],
            'users' => [
                'nullable',
                'array'
            ],
            'users.*' => [
                'integer',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'activity' => [
                'integer'
            ]
        ];
    }
}
