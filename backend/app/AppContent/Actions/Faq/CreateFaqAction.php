<?php

namespace App\AppContent\Actions\API;

use App\AppContent\Domain\Requests\FaqFormRequest;
use App\AppContent\Domain\Services\API\CreateFaqService;
use App\AppContent\Responders\API\CreateFaqResponder;

class CreateFaqAction
{
    private $service;

    private $responder;

    public function __construct(CreateFaqResponder $responder, CreateFaqService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(FaqFormRequest $request)
    {
        return $this->responder->withResponse(
           $this->service->handle($request->validated())
        )->respond();
    }
}
