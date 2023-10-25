<?php

namespace App\AppContent\Responders\API;

use App\AppContent\Domain\Resources\FaqResource;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Responders\Responder;

class UpdateFaqResponder extends Responder
{
    use RESTApi;

    public function respond()
    {
        if ($this->response->getStatus() != 200) {
            return $this->sendError($this->response->getData());
        }

        return $this->sendJson(
            new FaqResource($this->response->getData()),
            $this->response->getStatus()
        );

    }
}
