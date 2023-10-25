<?php

namespace App\AppContent\Actions\Setting;

use App\AppContent\Domain\Requests\GenerateSettingRequest;
use App\AppContent\Domain\Requests\SettingRequest;
use App\AppContent\Domain\Services\Setting\CountriesSettingService;
use App\AppContent\Responders\CountriesSettingResponder;

class ListCountriesSettingsAction
{
    public function __construct(protected CountriesSettingResponder $responder, protected CountriesSettingService $service)
    {
        $this->responder = $responder;
        $this->service   = $service;
    }

    public function __invoke()
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}
