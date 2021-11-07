<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name'     => ['required'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'name.required'      => 'The name is required.',
            'email.required'     => 'The email address is required.',
            'email.email'        => 'The email address is invalid.',
            'email.unique'       => 'The email address already exists.',
            'password.required'  => 'The password is required.',
            'password.min'       => 'The password must be at least 6 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
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
