<?php

namespace App\User\Actions\Auth;

use App\User\Domain\Services\Auth\DeleteAccountService;
use App\User\Responders\UserResponder;

class DeleteAccountAction
{
    public function __construct(protected UserResponder $responder, protected DeleteAccountService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke()
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}
