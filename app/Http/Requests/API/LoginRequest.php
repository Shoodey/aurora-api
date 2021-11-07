<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email'    => ['bail', 'required', 'email', 'exists:users,email'],
            'password' => ['bail', 'required', 'min:6']
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => 'The email address is required.',
            'email.email'       => 'The email address is invalid.',
            'email.exists'      => 'The credentials do not match any record.',
            'password.required' => 'The password is required.',
            'password.min'      => 'The password must be at least 6 characters long.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Please make sure the fields are populated correctly.',
            'data'    => $validator->errors()
        ], 400));
    }
}
