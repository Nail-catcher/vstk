<?php

namespace App\Http\Requests;

use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdate extends FormRequest
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
                'email'
            ],
            'phone' => [
                'required',
                'phone:AUTO,RU,KZ'
            ],
            'role' => [
                'required',
                Rule::exists('roles', 'id')->whereNull('deleted_at')
            ],
            'position' => [
                'required',
                Rule::exists('positions', 'id')
            ],
            'division' => [
                'required',
                Rule::exists('divisions', 'id')
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    protected function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $this->whenFilled('current_password', function () use ($validator) {
            $validator->after(function (\Illuminate\Validation\Validator $validator) {
                $updater = new UpdateUserPassword();
                $updater->update($this->route()->parameter('user'), $this->only([
                    'current_password', 'password', 'password_confirmation'
                ]));
            });
        });

    }
}
