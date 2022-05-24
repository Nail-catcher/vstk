<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationStore extends FormRequest
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
            'stations' => [
                'required',
                'array',
                'min:1'
            ],
            'stations.*' => [
                'required',
                Rule::exists('stations', 'id')->whereNull('deleted_at')
            ],
            'deadline_at' => [
                'required',
                'date',
                'after_or_equal:now'
            ],
            'engineer' => [
                'nullable',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'users' => [
                'nullable',
                'array',
            ],
            'users.*' => [
                'required',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'priority' => [
                'required',
                Rule::in(['critical', 'major', 'minor']),
            ],
            'area' => [
                'required',
                'exists:areas,id'
            ],
            'project' => [
                'required',
                'exists:projects,id'
            ],
            'type' => [
                'required',
                'exists:types,id'
            ],
            'works' => [
                'nullable',
                'array'
            ],
            'works.*' => [
                'required',
                'exists:works,id'
            ],
            'ticket' => [
                'required_if:type,1',
                'exclude_if:type,2',
                'string',
                'max:255',
                Rule::unique('applications', 'ticket')
                    ->where('type_id', 1)
                    ->whereNull('deleted_at')
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'comment' => [
                'nullable',
                'string'
            ],
            'pickup_keys' => [
                'required',
                'boolean'
            ],
            'keys_comment' => [
                'nullable',
                'string'
            ]
        ];
    }
}
