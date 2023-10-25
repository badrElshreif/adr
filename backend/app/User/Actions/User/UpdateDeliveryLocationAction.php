<?php

namespace App\User\Actions\User;

use App\User\Domain\Requests\DeliveryLocationRequest;
use App\User\Domain\Services\User\UpdateDeliveryLocationService;
use App\User\Responders\UserResponder;

class UpdateDeliveryLocationAction
{
    public function __construct(UserResponder $responder, UpdateDeliveryLocationService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(DeliveryLocationRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
