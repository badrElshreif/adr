<?php

namespace App\AppContent\Actions\Page;

use App\AppContent\Domain\Services\Page\TogglePageStatusService;
use App\AppContent\Responders\PageResponder;

class TogglePageStatusAction
{
    public function __construct(PageResponder $responder, TogglePageStatusService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($slug)
    {
        return $this->responder->withResponse(
            $this->services->handle(['slug' => $slug])
        )->respond();
    }
}
