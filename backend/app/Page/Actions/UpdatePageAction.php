<?php

namespace App\Page\Actions;

use App\Page\Domain\Requests\PageRequest;
use App\Page\Domain\Services\UpdatePageService;
use App\Page\Responders\PageResponder;

class UpdatePageAction
{
    public function __construct(protected PageResponder $responder, protected UpdatePageService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke(PageRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ['page_id' => $id]))
        )->respond();
    }
}
