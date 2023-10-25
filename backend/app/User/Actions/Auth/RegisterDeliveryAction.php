<?php

namespace App\User\Actions\Auth;

use App\User\Domain\Requests\RegisterDeliveryFormRequest;
use App\User\Domain\Services\Auth\RegisterDeliveryService;
use App\User\Responders\UserResponder;

class RegisterDeliveryAction
{
    public function __construct(UserResponder $responder, RegisterDeliveryService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(RegisterDeliveryFormRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
