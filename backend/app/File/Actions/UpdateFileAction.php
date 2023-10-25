<?php

namespace App\File\Actions;

use App\File\Domain\Requests\FileRequest;
use App\File\Domain\Services\UpdateFileService;
use App\File\Responders\FileResponder;

class UpdateFileAction
{
    public function __construct(protected FileResponder $responder, protected UpdateFileService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke(FileRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ['file_id' => $id]))
        )->respond();
    }
}
