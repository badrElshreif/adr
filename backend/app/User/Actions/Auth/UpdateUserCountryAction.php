<?php

namespace App\User\Actions\Auth;

use App\User\Domain\Services\Auth\UpdateUserCountryService;
use App\User\Responders\UserResponder;
use Illuminate\Http\Request;

class UpdateUserCountryAction
{
    public function __construct(UserResponder $responder, UpdateUserCountryService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->all())
        )->respond();
    }
}
