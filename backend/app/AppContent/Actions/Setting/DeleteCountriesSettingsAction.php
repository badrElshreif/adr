<?php

namespace App\AppContent\Actions\Setting;

use App\AppContent\Domain\Requests\GenerateSettingRequest;
use App\AppContent\Domain\Requests\SettingRequest;
use App\AppContent\Domain\Services\Setting\DeleteCountriesSettingsService;
use App\AppContent\Responders\SettingResponder;

class DeleteCountriesSettingsAction
{
    public function __construct(protected SettingResponder $responder, protected DeleteCountriesSettingsService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->service->handle(['country_id' => $id])
        )->respond();
    }
}
