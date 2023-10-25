<?php

namespace App\AppContent\Actions\HomeContent;

use App\AppContent\Domain\Requests\PageRequest;
use App\AppContent\Domain\Services\HomeContent\ListContentService;
use App\AppContent\Responders\ContentResponder;

class ListContentAction
{
    public function __construct(ContentResponder $responder, ListContentService $services)
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
