<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgressInstall extends FormRequest
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
            'inventories' => ['required', 'array', 'min:1'],
            'inventories.*' => [
                'required',
                Rule::exists('inventories', 'id')->whereNull('deleted_at'),
                Rule::exists('inventory_user', 'inventory_id')
                    ->whereNull('installed_at')
                    ->where('user_id', $this->user()->id)
            ],
            'comment' => [
                'nullable',
                'string'
            ]
        ];
    }
}
