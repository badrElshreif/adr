<?php

namespace App\File\Actions;

use App\File\Domain\Requests\UpdateFileStatusFormRequest;
use App\File\Domain\Services\ToggleFileStatusService;
use App\File\Responders\FileResponder;

class ToggleFileStatusAction
{
    public function __construct(protected FileResponder $responder, protected ToggleFileStatusService $services)
    {
        $this->responder = $responder;
        $this->services  = $services;
    }

    public function __invoke(UpdateFileStatusFormRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ['file_id' => $id]))
        )->respond();
    }
}
