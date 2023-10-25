<?php

namespace App\User\Responders\API;

use App\Infrastructure\Helpers\Traits\ApiPaginator;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Responders\Responder;
use App\User\Domain\Resources\UserLiteResource;
use App\User\Domain\Resources\UserResource;

class ListUsersResponder extends Responder
{
    use ApiPaginator, RESTApi;

    public function respond()
    {

        if (isset(request()->is_detailed) && request()->is_detailed == 'false') {
            return $this->sendJson(
                UserLiteResource::collection($this->response->getData())
            );
        }

        return $this->sendJson(
            $this->getPaginatedResponse(
                $this->response->getData(),
                UserResource::collection($this->response->getData())
            ),
            $this->response->getStatus()
        );
    }
}
