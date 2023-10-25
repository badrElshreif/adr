<?php

namespace App\AppContent\Actions\Statistics;

use App\AppContent\Domain\Services\Statistics\GetStatisticsService;
use App\AppContent\Responders\SettingResponder;
use Illuminate\Http\Request;

class GetStatisticsAction
{
    public function __construct(protected SettingResponder $responder, protected GetStatisticsService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->all())
        )->respond();
    }
}
