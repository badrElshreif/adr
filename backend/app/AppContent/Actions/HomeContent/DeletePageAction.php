<?php

namespace App\AppContent\Actions\Page;

use App\AppContent\Domain\Services\Page\DeletePageService;
use App\AppContent\Responders\PageResponder;

class DeletePageAction
{
    public function __construct(PageResponder $responder, DeletePageService $services)
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
