<?php

namespace App\AppContent\Actions\Setting;

use App\AppContent\Domain\Requests\GenerateSettingRequest;
use App\AppContent\Domain\Requests\SettingRequest;
use App\AppContent\Domain\Services\Setting\GenerateSettingsService;
use App\AppContent\Responders\SettingResponder;

class GenerateSettingsAction
{
    public function __construct(protected SettingResponder $responder, protected GenerateSettingsService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke(GenerateSettingRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
