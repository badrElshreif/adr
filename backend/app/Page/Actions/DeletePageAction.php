<?php

namespace App\Page\Actions;

use App\Page\Domain\Services\DeletePageService;
use App\Page\Responders\PageResponder;

class DeletePageAction
{
    public function __construct(protected PageResponder $responder, protected DeletePageService $service)
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
