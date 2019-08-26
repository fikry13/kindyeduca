<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Restrict the fields that the user can change.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->only(backpack_authentication_column(), 'name', 'address', 'gender','age', 'phone', 'latitude', 'longitude', 'description', 'distance', 'grade_id', 'skill_id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = backpack_auth()->user();

        $isTeacher = $user->hasRole('teacher');
        $isStudent = $user->hasRole('student');

        if($isTeacher)
        {
            return [
                backpack_authentication_column() => [
                    'required',
                    backpack_authentication_column() == 'email' ? 'email' : '',
                    Rule::unique($user->getTable())->ignore($user->getKey(), $user->getKeyName()),
                ],
                'name' => 'required',
                'address' => 'required',
                'gender' => 'required|in:0,1',
                'age' => 'required',
                'phone' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'skill_id' => 'required',
            ];
        }
        else if($isStudent)
        {
            return [
                backpack_authentication_column() => [
                    'required',
                    backpack_authentication_column() == 'email' ? 'email' : '',
                    Rule::unique($user->getTable())->ignore($user->getKey(), $user->getKeyName()),
                ],
                'name' => 'required',
                'address' => 'required',
                'gender' => 'required|in:0,1',
                'age' => 'required',
                'phone' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'grade_id' => 'required',
            ];
        }
        else
        {
            return [
                backpack_authentication_column() => [
                    'required',
                    backpack_authentication_column() == 'email' ? 'email' : '',
                    Rule::unique($user->getTable())->ignore($user->getKey(), $user->getKeyName()),
                ],
                'name' => 'required',
            ];
        }
    }
}
