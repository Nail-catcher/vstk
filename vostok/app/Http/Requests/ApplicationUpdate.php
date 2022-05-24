<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationUpdate extends FormRequest
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
            'status' => [
                'nullable',
                Rule::exists('statuses', 'id')
            ],
            'deadline_at' => [
                'nullable',
                'date',
                'after_or_equal:now'
            ],
            'comment' => [
                'nullable',
                'string',
                'min:3'
            ],
            'user' => [
                'nullable',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'engineer' => [
                'nullable',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'users' => [
                // 'nullable',                
                // 'array',
                
            ],
            'users.*' => [
                
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'works' => [
                'nullable',
                'array',
                'min:1'
            ],
            'works.*' => [
                'required',
                'exists:works,id'
            ],
        ];
    }
}
