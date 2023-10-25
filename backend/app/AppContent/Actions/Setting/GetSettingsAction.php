<?php

namespace App\AppContent\Actions\Setting;

use App\AppContent\Domain\Requests\SettingRequest;
use App\AppContent\Domain\Services\Setting\GetSettingsService;
use App\AppContent\Responders\SettingResponder;

class GetSettingsAction
{
    public function __construct(protected SettingResponder $responder, protected GetSettingsService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke(SettingRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
