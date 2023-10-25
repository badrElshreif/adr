<?php

namespace App\AppContent\Actions\API;

use App\AppContent\Domain\Requests\SendPromotionMailFormRequest;
use App\AppContent\Domain\Services\API\SendPromotionMailService;
use App\AppContent\Responders\API\SendPromotionMailResponder;

class SendPromotionMailAction
{
    private $service;

    private $responder;

    public function __construct(SendPromotionMailResponder $responder, SendPromotionMailService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(SendPromotionMailFormRequest $request)
    {
        return $this->responder->withResponse(
           $this->service->handle($request->validated())
        )->respond();
    }
}
