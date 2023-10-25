<?php

namespace App\AppContent\Actions\Page;

use App\AppContent\Domain\Requests\PageRequest;
use App\AppContent\Domain\Services\Page\CreatePageService;
use App\AppContent\Responders\PageResponder;

class CreatePageAction
{
    public function __construct(PageResponder $responder, CreatePageService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PageRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
