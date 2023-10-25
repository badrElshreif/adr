<?php

namespace App\AppContent\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class PageRequest extends CustomApiRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return [
                    'orderBy' => [
                        'sometimes',
                        'nullable',
                        Rule::in(['id', 'created_at', 'is_active']),
                    ],
                    'orderType' => [
                        'sometimes',
                        'nullable',
                        Rule::in(['ASC', 'DESC', 'asc', 'desc']),
                    ],
                    'is_paginated' => ['nullable'],
                    'active' => ['nullable'],
                    'is_detailed' => ['nullable'],
                    'per_page' => ['nullable', 'numeric', 'gte:1'],
                ];

            case 'POST':
                return [
                    'en.title' => ['required', 'max:225'],
                    'ar.title' => ['required', 'max:225'],
                    'en.body' => ['required'],
                    'ar.body' => ['required'],
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'en.title' => ['required', 'max:225'],
                    'ar.title' => ['required', 'max:225'],
                    'en.body' => ['required'],
                    'ar.body' => ['required'],
                ];

            default:break;

        }
    }
}
