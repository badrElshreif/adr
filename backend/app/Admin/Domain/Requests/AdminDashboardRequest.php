<?php

namespace App\Admin\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminDashboardRequest extends CustomApiRequest
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
                    'is_paginated' => ['sometimes', 'nullable']
                ];
            case 'DELETE':
                return [];

            case 'POST':
                $rules = [
                    'name'        => ['required', 'min:4', 'max:40', 'string'],
                    'phone'       => ['sometimes', 'digits_between:7,13', 'unique:admins,phone'],
                    'email'       => ['required', 'email', 'unique:admins,email'],
                    'password'    => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
                    'avatar'      => ['nullable', 'nullable', 'url'],
                    'roles'       => ['nullable', 'array'],
                    'roles.*'     => ['nullable', 'numeric', 'exists:roles,id'],
                    'is_active'   => ['nullable', 'boolean'],
                    'tax'         => ['nullable', 'numeric'],
                    'category_id' => ['nullable', 'exists:categories,id']
                ];

                if (auth()->guard('company')->check() || auth()->guard('focus')->check())
                {
                    $rules = array_merge($rules, [
                    ]);
                }

                return $rules;
            case 'PUT':
            case 'PATCH':
                //$id = $this->route('id');
                $id = isset($this->id) ? $this->id : (auth('company')->check() ? auth('company')->id() : auth()->id());
                Log::info('id: ' . $id);
                $rules = [
                    'name'      => ['sometimes', 'min:4', 'max:40', 'string'],
                    //'phone' => ['sometimes', 'digits_between:7,13', 'unique:admins,phone,'.$id],

                    'avatar'    => ['sometimes', 'url'],
                    'image'     => ['nullable', 'url'],
                    'is_active' => ['nullable', 'boolean'],
                    'en.name'   => [
                        'sometimes',
                        'max:255'
                    ],
                    'ar.name'   => [
                        'sometimes',
                        'max:255'
                    ],

                    'password'  => ['nullable', 'string', 'min:8', 'max:32']
                ];

                if (isset($this->id))
                {
                    $rules = array_merge($rules, [
                        'roles'   => ['required', 'array'],
                        'roles.*' => ['sometimes', 'numeric', 'exists:roles,id']]);
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
