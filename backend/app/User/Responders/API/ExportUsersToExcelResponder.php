<?php

namespace App\User\Responders\API;

use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Responders\Responder;

class ExportUsersToExcelResponder extends Responder
{
    use RESTApi;

    public function respond()
    {
        return $this->response->getData();
    }
}
