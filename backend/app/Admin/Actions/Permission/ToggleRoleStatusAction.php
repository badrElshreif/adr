<?php

namespace App\Admin\Actions\Permission;

use App\Admin\Domain\Services\Permission\ToggleRoleStatusService;
use App\Admin\Responders\RoleResponder;

class ToggleRoleStatusAction
{
    public function __construct(RoleResponder $responder, ToggleRoleStatusService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->service->handle(['role_id' => $id])
        )->respond();
    }
}
