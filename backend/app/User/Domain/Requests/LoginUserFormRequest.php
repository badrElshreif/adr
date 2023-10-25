<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class LoginUserFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'phone' => 'required|numeric|digits_between:7,17|exists:users,phone',
            //            'phone' => 'nullable|numeric|digits_between:7,17',
            'email'        => 'nullable|email|min:7|max:75',
            'type'         => ['required', 'in:client,delivery'],
            'country_code' => ['nullable', 'exists:countries,phone_code'],
            'password'     => 'required|string|max:32|min:8',
            'remember_me'  => 'nullable|nullable|boolean',
            'device_token' => 'nullable|nullable|string|max:1000|min:1',
            'device_id'    => 'nullable|nullable|string|max:255|min:1',
        ];
    }
}
