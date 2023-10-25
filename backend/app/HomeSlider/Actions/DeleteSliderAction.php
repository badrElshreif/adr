<?php

namespace App\HomeSlider\Actions;

use App\HomeSlider\Domain\Services\DeleteSliderService;
use App\HomeSlider\Responders\BannerResponder;

class DeleteSliderAction
{
    public function __construct(BannerResponder $responder, DeleteSliderService $services)
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
