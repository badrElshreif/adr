<?php

namespace App\Page\Actions;

use App\Page\Domain\Requests\PageRequest;
use App\Page\Domain\Services\CreatePageService;
use App\Page\Responders\PageResponder;

class CreatePageAction
{
    public function __construct(protected PageResponder $responder, protected CreatePageService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke(PageRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
