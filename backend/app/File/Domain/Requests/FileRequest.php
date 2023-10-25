<?php

namespace App\File\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class FileRequest extends CustomApiRequest
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
                    'type'           => ['required', 'in:background,sound'],
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
                    'is_active'              => ['nullable', 'boolean'],
                    'appear_to_free_package' => ['nullable', 'boolean'],
                    'icon'                   => ['required', 'url'],
                    'file'                   => ['required', 'url'],
                    'type'                   => ['required', 'in:background,sound']
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
                    'is_active'              => ['nullable', 'boolean'],
                    'appear_to_free_package' => ['nullable', 'boolean'],
                    'icon'                   => ['required', 'url'],
                    'file'                   => ['required', 'url'],
                    'type'                   => ['required', 'in:background,sound']
                ];

            default:
                break;

        }

    }

}
