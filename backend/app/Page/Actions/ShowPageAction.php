<?php

namespace App\Page\Actions;

use App\Page\Domain\Services\ShowPageService;
use App\Page\Responders\PageResponder;

class ShowPageAction
{
    public function __construct(protected PageResponder $responder, protected ShowPageService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->service->handle(['page_id' => $id])
        )->respond();
    }
}
