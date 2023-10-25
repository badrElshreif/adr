<?php

namespace App\HomeSlider\Actions;

use App\HomeSlider\Domain\Requests\BannerRequest;
use App\HomeSlider\Domain\Services\CreateSliderService;
use App\HomeSlider\Responders\BannerResponder;

class CreateSliderAction
{
    public function __construct(BannerResponder $responder, CreateSliderService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(BannerRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
