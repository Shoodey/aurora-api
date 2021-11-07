<?php

namespace App\Http\Requests\API;

class UpdateChannelRequest extends StoreChannelRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        // $rules['input'] = ['rules'];

        return $rules;
    }
}
