<?php

namespace App\Admin\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class LoginAdminFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'email'        => ['required', 'email', 'min:6', 'max:255'],
            'password'     => ['required', 'string', 'min:6', 'max:255'],
            'remember_me'  => ['nullable', 'boolean'],
            'device_token' => ['nullable', 'string']
        ];
    }
}
