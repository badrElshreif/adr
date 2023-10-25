<?php

namespace App\Admin\Actions\Auth;

use App\Admin\Domain\Requests\LoginAdminFormRequest;
use App\Admin\Domain\Services\Auth\LoginAdminService;
use App\Admin\Responders\LoginAdminResponder;

class LoginAdminAction
{
    public function __construct(protected LoginAdminResponder $responder, protected LoginAdminService $services)
    {
        $this->responder = $responder;
        $this->services  = $services;
    }

    public function __invoke(LoginAdminFormRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
