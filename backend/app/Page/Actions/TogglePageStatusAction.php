<?php

namespace App\Page\Actions;

use App\Page\Domain\Requests\UpdatePageStatusFormRequest;
use App\Page\Domain\Services\TogglePageStatusService;
use App\Page\Responders\PageResponder;

class TogglePageStatusAction
{
    public function __construct(protected PageResponder $responder, protected TogglePageStatusService $services)
    {
        $this->responder = $responder;
        $this->services  = $services;
    }

    public function __invoke(UpdatePageStatusFormRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ['page_id' => $id]))
        )->respond();
    }
}
