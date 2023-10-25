<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterUserFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'min:4', 'max:40', 'string'],
            //            'send_type' => ['required', 'in:sms,email'],
            //'phone' => ['required', 'digits_between:7,17', 'unique:users,phone'],
            'phone' => ['required', 'digits_between:7,17'],
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->where('type', 'client')->whereNull('deleted_at')],
            'password' => ['required', 'string', Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols(), 'confirmed'],
            'gender' => ['sometimes', 'required', 'in:male,female'],
            'avatar' => ['nullable', 'url'],
            'country_code' => ['required', 'exists:countries,phone_code'],
            //            'latitude' => ['required', 'max:255'],
            //            'longitude' => ['required', 'max:255'],
            'confirmation' => ['required', 'in:1'],
        ];
    }
}
