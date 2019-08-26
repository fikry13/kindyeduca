<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        $user = backpack_auth()->user();
        return backpack_auth()->check() && $user->hasAnyRole('admin|owner');
    }

    protected function validationData()
    {
        return $this->only('name', 'color');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('subjects')->ignore($this->id,'id')
            ],
            'color' => 'required'
        ];
    }
}
