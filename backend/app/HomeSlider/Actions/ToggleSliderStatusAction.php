<?php

namespace App\HomeSlider\Actions;

use App\HomeSlider\Domain\Services\ToggleSliderStatusService;
use App\HomeSlider\Responders\BannerResponder;

class ToggleSliderStatusAction
{
    public function __construct(BannerResponder $responder, ToggleSliderStatusService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->services->handle(['slider_id' => $id])
        )->respond();
    }
}
