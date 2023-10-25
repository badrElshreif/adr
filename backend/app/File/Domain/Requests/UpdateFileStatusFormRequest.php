<?php

namespace App\File\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class UpdateFileStatusFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'is_active' => ['sometimes', 'nullable', 'boolean']
        ];
    }
}
