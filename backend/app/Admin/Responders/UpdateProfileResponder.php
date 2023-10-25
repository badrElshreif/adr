<?php

namespace App\Admin\Responders;

use App\Infrastructure\Helpers\Traits\RESTApi;
// use App\Admin\Domain\Resources\AdminResource;
use App\Infrastructure\Responders\Responder;

class UpdateProfileResponder extends Responder
{
    use RESTApi;

    public function respond()
    {

        if ($this->response->getStatus() != 200)
        {
            return $this->sendError($this->response->getData());
        }

        return $this->sendJson($this->response->getData(), $this->response->getStatus());

    }

}
