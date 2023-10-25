<?php

namespace App\HomeSlider\Actions;

use App\HomeSlider\Domain\Services\ShowSliderService;
use App\HomeSlider\Responders\BannerResponder;

class ShowSliderAction
{
    public function __construct(BannerResponder $responder, ShowSliderService $services)
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
