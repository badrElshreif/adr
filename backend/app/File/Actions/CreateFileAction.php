<?php

namespace App\File\Actions;

use App\File\Domain\Requests\FileRequest;
use App\File\Domain\Services\CreateFileService;
use App\File\Responders\FileResponder;

class CreateFileAction
{
    public function __construct(protected FileResponder $responder, protected CreateFileService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke(FileRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
