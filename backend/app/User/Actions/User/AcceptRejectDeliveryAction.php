<?php

namespace App\User\Actions\User;

use App\User\Domain\Requests\AcceptRejectDeliveryRequest;
use App\User\Domain\Services\User\AcceptRejectDeliveryService;
use App\User\Responders\UserResponder;

class AcceptRejectDeliveryAction
{
    public function __construct(UserResponder $responder, AcceptRejectDeliveryService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(AcceptRejectDeliveryRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ['user_id' => $id]))
        )->respond();
    }
}
