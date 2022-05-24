<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationRouteStore extends FormRequest
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
            'application' => [
                'required',
                Rule::unique('application_route', 'application_id')
                    ->where('route_id', $this->route->id),
                Rule::exists('applications', 'id')->whereNull('deleted_at')
            ],
        ];
    }
}
