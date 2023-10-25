<?php

namespace App\Property\Responders;

use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Responders\Responder;
use App\Property\Domain\Resources\PropertyTypeResource;

class PropertyTypeResponder extends Responder
{
    use RESTApi;

    public function respond()
    {
        return $this->sendJson(
                PropertyTypeResource::collection($this->response->getData())
            );
    }
}
