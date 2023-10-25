<?php

namespace App\Page\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class UpdatePageStatusFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'is_active' => ['sometimes', 'nullable', 'boolean']
        ];
    }
}
