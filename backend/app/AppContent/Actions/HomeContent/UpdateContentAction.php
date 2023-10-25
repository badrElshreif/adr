<?php

namespace App\AppContent\Actions\HomeContent;

use App\AppContent\Domain\Requests\PageRequest;
use App\AppContent\Domain\Services\HomeContent\UpdateContentService;
use App\AppContent\Responders\ContentResponder;

class UpdateContentAction
{
    public function __construct(ContentResponder $responder, UpdateContentService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(PageRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ['content_id' => $id]))
        )->respond();
    }
}
