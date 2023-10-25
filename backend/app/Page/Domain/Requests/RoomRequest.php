<?php

namespace App\Page\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class PageRequest extends CustomApiRequest
{
    public function rules()
    {

        switch ($this->method())
        {
            case 'GET':

                return [
                    'orderBy'        => [
                        'nullable',
                        Rule::in(['id', 'name', 'created_at', 'is_active'])
                    ],
                    'orderType'      => [
                        'nullable',
                        Rule::in(['ASC', 'DESC', 'asc', 'desc'])
                    ],
                    'store_id'       => ['nullable', 'exists:stores,id'],
                    'is_paginated'   => ['nullable'],
                    'all'            => ['nullable'],
                    'type'           => ['required', 'in:global'],
                    'active'         => ['nullable', 'in:1,0'],
                    'has_pagination' => ['nullable'],
                    'has_stores'     => ['nullable', 'in:1,0']
                ];

            case 'DELETE':

                return [];

            case 'POST':
                return [
                    'en.name'                => [
                        'required',
                        'max:255'
                    ],
                    'ar.name'                => [
                        'required',
                        'max:255'
                    ],
                    'en.description'         => [
                        'required',
                        'max:255'
                    ],
                    'ar.description'         => [
                        'required',
                        'max:255'
                    ],
                    'password'               => ['nullable', 'string'],
                    'is_active'              => ['nullable', 'boolean'],
                    'appear_to_free_package' => ['nullable', 'boolean'],
                    'image'                  => ['required', 'url'],
                    'type'                   => ['required', 'in:global']
                    //    'order'                  => ['nullable', 'numeric']
                ];

            case 'PUT':
            case 'PATCH':

                return [
                    'en.name'                => [
                        'required',
                        'max:255'
                    ],
                    'ar.name'                => [
                        'required',
                        'max:255'
                    ],
                    'en.description'         => [
                        'required',
                        'max:255'
                    ],
                    'ar.description'         => [
                        'required',
                        'max:255'
                    ],
                    'password'               => ['nullable', 'string'],
                    'is_active'              => ['nullable', 'boolean'],
                    'appear_to_free_package' => ['nullable', 'boolean'],
                    'image'                  => ['required', 'url'],
                    'type'                   => ['required', 'in:global']
                    //    'order'                  => ['nullable', 'numeric']
                ];

            default:
                break;

        }

    }

}
