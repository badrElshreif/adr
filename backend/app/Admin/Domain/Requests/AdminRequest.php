<?php

namespace App\Admin\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminRequest extends CustomApiRequest
{
    public function rules()
    {

        switch ($this->method())
        {
            case 'GET':
                return [
                    'orderBy'      => [
                        'sometimes',
                        'nullable',
                        Rule::in(['id', 'name', 'phone', 'created_at', 'email', 'is_active'])
                    ],
                    'orderType'    => [
                        'sometimes',
                        'nullable',
                        Rule::in(['ASC', 'DESC', 'asc', 'desc'])
                    ],
                    'is_paginated' => ['sometimes', 'nullable'],
                    'country_id'   => ['nullable', 'exists:countries,id'],
                    'state_id'     => ['nullable', 'exists:states,id'],
                    'city_id'      => ['nullable', 'exists:cities,id']
                ];
            case 'DELETE':
                return [];

            case 'POST':
                $rules = [
                    'name'         => ['required', 'min:4', 'max:40', 'string'],
                    'phone'        => ['sometimes', 'digits_between:7,13', 'unique:admins,phone'],
                    'email'        => ['required', 'email', 'unique:admins,email'],
                    'password'     => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
                    'avatar'       => ['nullable', 'nullable', 'url'],
                    //    'roles'        => ['nullable', 'array'],
                    'roles'        => ['required', 'numeric', 'exists:roles,id'],
                    'country_id'   => ['nullable', 'array'],
                    'country_id.*' => ['nullable', 'numeric', 'exists:countries,id'],
                    'state_id'     => ['nullable', 'array'],
                    'state_id.*'   => ['nullable', 'numeric', 'exists:states,id'],
                    'category_id'  => ['nullable', 'exists:categories,id'],
                    'city_id'      => ['nullable', 'array'],
                    'city_id.*'    => ['nullable', 'numeric', 'exists:cities,id'],
                    'is_active'    => ['nullable', 'boolean'],
                    'tax'          => ['nullable', 'numeric']
                ];

                if (auth()->guard('company')->check() || auth()->guard('focus')->check())
                {
                    $rules = array_merge($rules, [

//                        'phone' => ['sometimes', 'digits_between:7,13', 'unique:admins,phone','unique:users,phone'],
                        //                        'email' => ['required', 'email','unique:admins,email','unique:users,email'],
                    ]);
                }

                return $rules;
            case 'PUT':
            case 'PATCH':
                //$id = $this->route('id');
                $id = isset($this->id) ? $this->id : (auth('store')->check() ? auth('store')->id() : auth()->id());
                Log::info('id: ' . $id);
                $rules = [
                    'name'            => ['sometimes', 'min:4', 'max:40', 'string'],
                    'username'        => ['sometimes', 'min:4', 'max:40', 'string'],
                    //'phone' => ['sometimes', 'digits_between:7,13', 'unique:admins,phone,'.$id],

                    'avatar'          => ['sometimes', 'url'],
                    'image'           => ['nullable', 'url'],
                    'country_id'      => ['nullable', 'array'],
                    'country_id.*'    => ['nullable', 'numeric', 'exists:countries,id'],
                    'state_id'        => ['nullable', 'array'],
                    'state_id.*'      => ['nullable', 'numeric', 'exists:states,id'],
                    'city_id'         => ['nullable', 'array'],
                    'city_id.*'       => ['nullable', 'numeric', 'exists:cities,id'],
                    'is_active'       => ['nullable', 'boolean'],
                    'is_online'       => ['nullable', 'boolean'],
                    'address'         => ['nullable', 'string'],
                    'latitude'        => ['nullable', 'string'],
                    'longitude'       => ['nullable', 'string'],
                    'category_id'     => ['nullable', 'exists:categories,id'],
                    'en.name'         => [
                        'sometimes',
                        'max:255'

// Rule::unique('store_translations', 'name')

//     ->where(function ($query) {

//         $query->where('locale', 'en');
                        //     })
                    ],
                    'ar.name'         => [
                        'sometimes',
                        'max:255'

// Rule::unique('store_translations', 'name')

//     ->where(function ($query) {

//         $query->where('locale', 'ar');
                        //     })
                    ],

                    'password'        => ['nullable', 'string', 'min:8', 'max:32'],
                    'bank_type'       => ['nullable', 'in:local,global'],
                    'bank_user_name'  => ['nullable', 'string', 'max:255'],
                    'bank_name'       => ['nullable', 'string', 'max:255'],
                    'bank_account_no' => ['required_if:bank_type,local', 'string', 'max:255'],
                    'iban_no'         => ['required_if:bank_type,local|unique:companies,iban_no,' . $this->user()->id, 'string', 'max:255'],
                    // 'iban_no' => ['required_if:bank_type,local',Rule::unique('companies','iban_no')->ignore(auth()->user()->company_id), 'string', 'max:255'],
                    'swift_code'      => ['required_if:bank_type,global', 'string', 'max:255'],
                    'bank_country_id' => ['required_if:bank_type,global', 'exists:countries,id'],
                    'tax'             => ['nullable', 'numeric']
                ];

                if (isset($this->id))
                {
                    $rules = array_merge($rules, [
                        //   'roles' => ['required', 'array'],
                        'roles' => ['required', 'numeric', 'exists:roles,id']]);
                }

                if (auth()->guard('company')->check() || auth()->guard('focus')->check())
                {
                    $rules = array_merge($rules, [
                        'phone' => ['sometimes', 'digits_between:7,17', 'unique:admins,phone,' . $id],
                        'email' => ['sometimes', 'email', 'unique:admins,email,' . $id]
                    ]);
                }
                else
                {
                    $rules = array_merge($rules, [
                        'phone' => ['required', 'digits_between:7,17', Rule::unique('admins', 'phone')->ignore($id)],
                        'email' => ['required', 'email', 'unique:admins,email,' . $id]
                    ]);

                }

                return $rules;
        }

    }

}
