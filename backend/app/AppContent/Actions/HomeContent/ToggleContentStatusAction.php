<?php

namespace App\AppContent\Actions\HomeContent;

use App\AppContent\Domain\Services\HomeContent\ToggleContentStatusService;
use App\AppContent\Responders\ContentResponder;

class ToggleContentStatusAction
{
    public function __construct(ContentResponder $responder, ToggleContentStatusService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->services->handle(['content_id' => $id])
        )->respond();
    }
}
