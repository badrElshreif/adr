<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileFormRequest extends CustomApiRequest
{
    public function rules()
    {
        $id = optional(auth()->user())->id;

        return [
            'name' => ['sometimes', 'min:4', 'max:40', 'string'],
            //'phone' => ['sometimes', 'digits_between:7,17', 'unique:users,phone,'.$id],
            'phone'                => ['sometimes', 'digits_between:7,17'],
            'email'                => ['sometimes', 'nullable', 'email', Rule::unique('users', 'email')->where('type', auth()->user()->type)->ignore($id)],
            'avatar'               => ['sometimes', 'nullable', 'url'],
            'is_active'            => ['sometimes', 'numeric'],
            'country_code'         => ['nullable', 'exists:countries,phone_code'],
            'latitude'             => ['sometimes', 'string', 'max:255'],
            'longitude'            => ['sometimes', 'string', 'max:255'],
            'address'              => ['nullable', 'max:255'],
            'city_id'              => ['nullable', 'exists:cities,id'],
            'national_card_serial' => ['nullable', 'max:255'],
            'national_card_image'  => ['nullable', 'max:255'],
            'license_image'        => ['nullable', 'max:255'],
            'vehicle_model'        => ['nullable', 'max:255'],
            'vehicle_type'         => ['nullable', 'max:255'],
            'vehicle_plate_number' => ['nullable', 'max:255'],
            'bank_name'            => ['nullable', 'max:255'],
            'iban_number'          => ['nullable', 'max:255'],
            'bank_account'         => ['nullable', 'max:255'],
            'stc_number'           => ['nullable', 'max:255'],
            'status'               => ['nullable', 'in:0,1'],
        ];
    }
}
