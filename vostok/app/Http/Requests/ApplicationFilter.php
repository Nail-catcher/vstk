<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationFilter extends FormRequest
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

    //    protected function prepareForValidation(): void
    //    {
    //        if ($this->filled('date')) {
    //            $date = explode('-', $this->date);
    //            if (count($date) > 1) {
    //                $this->merge([
    //                    'date_from' => $date[0],
    //                    'date_to' => $date[1]
    //                ]);
    //            }
    //        }
    //        $this->merge([
    //            'date_from' => $this->from,
    //            'date_to' => $this->to,
    //        ]);
    //    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'limit' => ['numeric'],
            'id' => [
                'nullable',
                'numeric',
                'min:1'
            ],
            'ids' => ['nullable', 'array'],
            'ids.*' => ['exists:applications,id'],
            'status' => [
                'nullable',
                'exists:statuses,id'
            ],
            'ticket' => [
                'nullable',
                'string',
                'max:255'
            ],
            'statuses' => [
                'nullable',
                'array'
            ],
            'statuses.*' => [
                'exists:statuses,id'
            ],
            'division' => [
                'nullable',
                'exists:divisions,id'
            ],
            'divisions' => [
                'nullable',
                'array'
            ],
            'area' => [
                'nullable',
                'exists:areas,id'
            ],
            'areas' => [
                'nullable',
                'array'
            ],
            'areas.*' => [
                'required',
                'exists:areas,id'
            ],
            'work' => [
                'nullable',
                'exists:works,id'
            ],
            'works' => [
                'nullable',
                'array'
            ],
            'work.*' => [
                'required',
                'exists:works,id'
            ],
            'type' => [
                'nullable',
                'exists:types,id'
            ],
            'types' => [
                'nullable',
                'array'
            ],
            'types.*' => [
                'required',
                'exists:types,id'
            ],
            'priority' => [
                'nullable',
                'array'
            ],
            'priority.*' => [
                Rule::in(['major', 'minor', 'critical'])
            ],
            'bts_id' => [
                'nullable',
                'string'
            ],
            'date_from' => [
                'nullable',
                'date'
            ],
            'date_to' => [
                'nullable',
                'date'
            ],
            'created_from' => [
                'nullable',
                'date'
            ],
            'created_to' => [
                'nullable',
                'date'
            ],
            'from' => [
                'nullable',
                'date'
            ],
            'to' => [
                'nullable',
                'date'
            ],
            'engineer' => [
                'nullable',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'stations' => [
                'nullable',
                'array'
            ],
            'stations.*' => [
                'required',
                Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
            'routes' => [
                'nullable',
                'array'
            ],
            'routes.*' => [
                'required',
            ],
            'project' => ['nullable', 'exists:projects,id'],
            'projects' => ['nullable', 'array'],
            'projects.*' => ['exists:projects,id']
        ];
    }
}
