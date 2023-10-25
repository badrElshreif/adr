<?php

namespace App\HomeSlider\Actions;

use App\HomeSlider\Domain\Requests\BannerRequest;
use App\HomeSlider\Domain\Services\UpdateSliderService;
use App\HomeSlider\Responders\BannerResponder;

class UpdateSliderAction
{
    public function __construct(BannerResponder $responder, UpdateSliderService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(BannerRequest $request, $id)
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ['slider_id' => $id]))
        )->respond();
    }
}
