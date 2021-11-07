<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class StoreChannelRequest extends FormRequest
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
            'name'        => ['bail', 'required', 'min:6'],
            'description' => ['bail', 'nullable'],
            'user_id'     => ['bail', 'required', 'exists:users,id'],
            'password'    => ['bail', 'nullable', 'min:6', 'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'name.min'      => 'The name must be at least 6 characters long.',

            'user_id.required' => 'The resource must be attached to an existing user.',
            'user_id.exists'   => 'The resource must be attached to an existing user.',

            'password.min'       => 'The password is must be at least 6 characeters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Please make sure the fields are populated correctly.',
            'data'    => $validator->errors()
        ], Response::HTTP_BAD_REQUEST));
    }
}
