<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgressReport extends FormRequest
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
            'works' => [
                //'required',
                'array',
                //'min:1'
            ],
            'works.*' => [
                //'required',
                //'exists:works,id'
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
            'comment' => [
                'required',
                'string'
            ]
        ];
    }
}
