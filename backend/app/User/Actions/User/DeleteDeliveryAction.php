<?php

namespace App\User\Actions\User;

use App\User\Domain\Services\User\DeleteDeliveryService;
use App\User\Responders\UserResponder;

class DeleteDeliveryAction
{
    public function __construct(UserResponder $responder, DeleteDeliveryService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->services->handle(['user_id' => $id])
        )->respond();
    }
}
