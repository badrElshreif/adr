<?php

namespace App\AppContent\Actions\HomeContent;

use App\AppContent\Domain\Services\HomeContent\GetContentService;
use App\AppContent\Responders\ContentResponder;

class GetContentAction
{
    private $service;

    private $responder;

    public function __construct(ContentResponder $responder, GetContentService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
           $this->service->handle(['content_id' => $id])
        )->respond();
    }
}
