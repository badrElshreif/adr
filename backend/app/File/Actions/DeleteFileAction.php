<?php

namespace App\File\Actions;

use App\File\Domain\Services\DeleteFileService;
use App\File\Responders\FileResponder;

class DeleteFileAction
{
    public function __construct(protected FileResponder $responder, protected DeleteFileService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->service->handle(['File_id' => $id])
        )->respond();
    }
}
