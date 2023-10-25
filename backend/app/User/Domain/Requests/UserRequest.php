<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class UserRequest extends CustomApiRequest
{
    public function rules()
    {
            switch ($this->method()) {
                case 'GET':
                    return [
                        'per_page' => ['sometimes', 'nullable', 'numeric', 'gte:1'],
                        'orderBy' => [
                            'nullable',
                            Rule::in(['id', 'name', 'created_at', 'is_active', 'phone', 'email']),
                        ],
                        'orderType' => [
                            'nullable',
                            Rule::in(['ASC', 'DESC', 'asc', 'desc']),
                        ],
                    ];

                case 'DELETE':
                    return [];

                case 'POST':
                    return [
                        'name' => ['required', 'min:4', 'max:40', 'string'],
                        //'phone' => ['required', 'digits_between:7,17', 'unique:users,phone'],
                        'phone' => ['required', 'digits_between:7,17', Rule::unique('users', 'phone')->where('type', 'client')],
                        'email' => ['nullable', 'email', Rule::unique('users', 'email')->where('type', 'client')],
                        'password' => ['nullable', 'string', 'min:8', 'max:32', 'confirmed'],
                        'gender' => ['nullable', 'required', 'in:male,female'],
                        //                        'country_code' => ['nullable', 'min:2', 'max:4', 'string'],
                        'avatar' => ['nullable', 'url'],
                        'is_active' => ['nullable', 'nullable', 'boolean'],
                        'country_code' => ['required', 'exists:countries,phone_code'],
                        'latitude' => ['nullable', 'string', 'max:255'],
                        'longitude' => ['nullable', 'string', 'max:255'],
                    ];

                case 'PUT':
                case 'PATCH':
                    $id = $this->route('id');

                    return [
                        'is_active' => ['nullable', 'boolean'],
                        'name' => ['nullable', 'min:4', 'max:40', 'string'],
                        //'phone' => ['nullable', 'digits_between:7,17', 'unique:users,phone,'.$id],
                        'phone' => ['nullable', 'digits_between:7,17'],
                        'email' => ['nullable', 'email'],
                        'avatar' => ['nullable', 'url'],
                        'country_code' => ['nullable', 'exists:countries,phone_code'],
                        'latitude' => ['sometimes', 'string', 'max:255'],
                        'longitude' => ['sometimes', 'string', 'max:255'],
                        'address' => ['nullable', 'max:255'],
                        'city_id' => ['nullable', 'exists:cities,id'],
                        'national_card_serial' => ['nullable', 'max:255'],
                        'national_card_image' => ['nullable', 'max:255'],
                        'license_image' => ['nullable', 'max:255'],
                        'vehicle_model' => ['nullable', 'max:255'],
                        'vehicle_type' => ['nullable', 'max:255'],
                        'vehicle_plate_number' => ['nullable', 'max:255'],
                        'bank_name' => ['nullable', 'max:255'],
                        'iban_number' => ['nullable', 'max:255'],
                        'bank_account' => ['nullable', 'max:255'],
                        'stc_number' => ['nullable', 'max:255'],
                        'status' => ['nullable', 'in:0,1'],
                    ];

                default:break;

                }
    }
}
