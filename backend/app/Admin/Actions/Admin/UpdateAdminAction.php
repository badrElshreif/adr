<?php

namespace App\Admin\Actions\Admin;

use App\Admin\Domain\Requests\AdminDashboardRequest;
use App\Admin\Domain\Services\Admin\UpdateAdminService;
use App\Admin\Responders\AdminResponder;

class UpdateAdminAction
{
    public function __construct(protected AdminResponder $responder, protected UpdateAdminService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(AdminDashboardRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ['admin_id' => $id]))
        )->respond();
    }
}
