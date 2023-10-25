<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class ResetUserPasswordFormRequest extends CustomApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'         => ['required', 'in:client,delivery'],
            //            'email' => ['required_if:send_type,email', 'email','max:75'],
            'phone'        => ['required', 'digits_between:7,17'],
            'country_code' => ['required', 'exists:countries,phone_code'],
            'password'     => ['required', 'min:6', 'max:32', 'confirmed'],
            'token'        => ['required']
        ];
    }
}
