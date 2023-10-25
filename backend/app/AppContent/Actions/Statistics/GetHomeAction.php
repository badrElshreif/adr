<?php

namespace App\AppContent\Actions\Statistics;

use App\AppContent\Domain\Services\Statistics\GetHomeService;
use App\AppContent\Responders\SettingResponder;
use Illuminate\Http\Request;

class GetHomeAction
{
    public function __construct(SettingResponder $responder, GetHomeService $services)
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
