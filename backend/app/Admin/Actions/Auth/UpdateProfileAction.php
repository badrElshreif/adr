<?php

namespace App\Admin\Actions\Auth;

use App\Admin\Domain\Requests\AdminDashboardRequest;
use App\Admin\Domain\Services\Auth\UpdateProfileService;
use App\Admin\Responders\UpdateProfileResponder;

class UpdateProfileAction
{
    public function __construct(protected UpdateProfileResponder $responder, protected UpdateProfileService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(AdminDashboardRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
