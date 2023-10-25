<?php

namespace App\File\Actions;

use App\File\Domain\Requests\FileRequest;
use App\File\Domain\Services\ListFilesService;
use App\File\Responders\FileResponder;

class ListFilesAction
{
    public function __construct(protected FileResponder $responder, protected ListFilesService $service)
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
