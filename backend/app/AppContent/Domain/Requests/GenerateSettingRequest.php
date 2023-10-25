<?php

namespace App\AppContent\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;
use Illuminate\Validation\Rule;

class GenerateSettingRequest extends CustomApiRequest
{
    public function rules()
    {

        switch ($this->method()) {
            case 'GET':
                return [
                    'target' => [
                        'nullable', 'in:superAdmin,stores,centers',
                        Rule::requiredIf(function () {
                            return ! auth()->check();
                        }),
                    ],
                ];

            case 'DELETE':
                return [];

            case 'POST':
                return [
                    'country_id' => ['required', 'numeric', 'exists:countries,id'],
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'country_id' => ['required', 'numeric', 'exists:countries,id'],
                ];

            default:break;
        }
    }
}
