<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class UserStore extends FormRequest
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
            'lastname' => [
                'required',
                'string',
                'min:2',
                'max:255'
            ],
            'firstname' => [
                'required',
                'string',
                'min:2',
                'max:255'
            ],
            'middlename' => [
                'nullable',
                'string',
                'min:2',
                'max:255'
            ],
            'email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('users', 'email')->whereNull('deleted_at')
            ],
            'phone' => [
                'required',
                'phone:AUTO,RU,KZ',
                Rule::unique('users', 'phone')->whereNull('deleted_at')
            ],
            'role' => [
                'required',
                Rule::exists('roles', 'id')->whereNull('deleted_at')
            ],
            'division' => [
                'required',
                Rule::exists('divisions', 'id')
            ],
            'area' => [
                'required',
                Rule::exists('areas', 'id')
            ],
            'position' => [
                'required',
                Rule::exists('positions', 'id')
            ],
            'password' => [
                'required',
                'string',
                new Password
            ],
        ];
    }
}
