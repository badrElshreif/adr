<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class RegisterDeliveryFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'min:4', 'max:40', 'string'],
            //            'send_type' => ['required', 'in:sms,email'],
            //'phone' => ['required', 'digits_between:7,17', 'unique:users,phone'],
            'phone'                => ['required', 'digits_between:7,17'],
            'email'                => ['nullable', 'email', Rule::unique('users', 'email')->where('type', 'delivery')->whereNull('deleted_at')],
            'password'             => ['required', 'string', Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols(), 'confirmed'],
            'gender'               => ['sometimes', 'required', 'in:male,female'],
            'country_code'         => ['required', 'exists:countries,phone_code'],
            'latitude'             => ['required', 'max:255'],
            'longitude'            => ['required', 'max:255'],
            'address'              => ['required', 'max:255'],
            'city_id'              => ['nullable', 'exists:cities,id'],
            'national_card_serial' => ['required', 'max:255'],
            'national_card_image'  => ['required', 'max:255'],
            'license_image'        => ['required', 'max:255'],
            'vehicle_model'        => ['nullable', 'max:255'],
            'vehicle_type'         => ['nullable', 'max:255'],
            'vehicle_plate_number' => ['nullable', 'max:255'],
            'bank_name'            => ['nullable', 'max:255'],
            'iban_number'          => ['nullable', 'max:255'],
            'bank_account'         => ['nullable', 'max:255'],
            'stc_number'           => ['nullable', 'max:255'],
            'confirmation'         => ['required', 'in:1'],
        ];
    }
}
