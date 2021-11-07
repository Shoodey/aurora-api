<?php

namespace App\Http\Requests\API;

class UpdateUserRequest extends StoreUserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules['email'] = ['bail', 'required', 'email', 'unique:users,email,' . $this->route('user')->id];

        return $rules;
    }
}
