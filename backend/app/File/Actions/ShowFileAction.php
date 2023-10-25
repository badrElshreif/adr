<?php

namespace App\File\Actions;

use App\File\Domain\Services\ShowFileService;
use App\File\Responders\FileResponder;

class ShowFileAction
{
    public function __construct(protected FileResponder $responder, protected ShowFileService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->service->handle(['file_id' => $id])
        )->respond();
    }
}
