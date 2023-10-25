<?php

namespace App\AppContent\Actions\Page;

use App\AppContent\Domain\Requests\PageRequest;
use App\AppContent\Domain\Services\Page\ListPagesService;
use App\AppContent\Responders\PageResponder;

class ListPagesAction
{
    public function __construct(PageResponder $responder, ListPagesService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PageRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}
