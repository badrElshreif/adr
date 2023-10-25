<?php

namespace App\Uploader\Responders\API;

use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Responders\Responder;

class UploadFileResponder extends Responder
{
    use RESTApi;

    public function respond()
    {
        if ($this->response->getStatus() != 200) {
            return $this->sendError($this->response->getData());
        }

        return $this->sendJson($this->response->getData(), $this->response->getStatus());
    }
}
