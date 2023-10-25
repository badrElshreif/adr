<?php

namespace App\User\Actions\User;

use App\Admin\Domain\Requests\AdminRequest;
use App\User\Domain\Services\User\ListUsersService;
use App\User\Responders\UserResponder;

class ListUsersAction
{
    public function __construct(protected UserResponder $responder, protected ListUsersService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(AdminRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
