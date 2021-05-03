<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;

class RegisterUserInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'sometimes',
                Rule::unique('users', 'email'),
            ],
            'name' => [
                'required'
            ],
            'password' => [
                'required'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email must be unique',
            'email.required' => 'Email is required',
            'name.required' => 'Username is required',
            'password.required' => 'Password is required',
        ];
    }
}
