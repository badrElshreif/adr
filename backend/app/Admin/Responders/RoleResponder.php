<?php

namespace App\Admin\Responders;

use App\Admin\Domain\Resources\RoleLiteResource;
use App\Admin\Domain\Resources\RoleResource;
use App\Infrastructure\Helpers\Traits\ApiPaginator;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Responders\ResponderInterface;
use Symfony\Component\HttpFoundation\Response;

class RoleResponder extends Responder implements ResponderInterface
{
    use RESTApi, ApiPaginator;

    public function respond()
    {
        if (! in_array($this->response->getStatus(), array_values(config('statuses.SUCCESS')))) {

            return $this->sendError($this->response->getData());
        }

        if ($this->response->getStatus() == Response::HTTP_CREATED) {
            return $this->sendJson(
                new RoleResource($this->response->getData()),
                $this->response->getStatus()
            );
        }

        if ($this->response->getStatus() == Response::HTTP_OK) {
            return $this->sendJson(
                RoleLiteResource::collection($this->response->getData()),
                $this->response->getStatus()
            );
        }

        if ($this->response->getStatus() == Response::HTTP_ACCEPTED) {

            return $this->sendJson(
                $this->getPaginatedResponse(
                    $this->response->getData(),
                    RoleLiteResource::collection($this->response->getData())
                )
            );
        }

        if ($this->response->getStatus() == Response::HTTP_NO_CONTENT) {

            return $this->sendJson($this->response->getData(), $this->response->getStatus());
        }

    }
}
