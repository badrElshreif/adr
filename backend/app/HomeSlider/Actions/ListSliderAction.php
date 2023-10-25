<?php

namespace App\HomeSlider\Actions;

use App\HomeSlider\Domain\Requests\BannerRequest;
use App\HomeSlider\Domain\Services\ListSliderService;
use App\HomeSlider\Responders\BannerResponder;

class ListSliderAction
{
    public function __construct(BannerResponder $responder, ListSliderService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(BannerRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}
