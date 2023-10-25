<?php

namespace App\User\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class AcceptRejectDeliveryRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'status' => ['required', 'numeric', 'in:1,2'],
            'rejection_reason' => ['required_if:status,2', 'string', 'max:255'],
        ];
    }
}
