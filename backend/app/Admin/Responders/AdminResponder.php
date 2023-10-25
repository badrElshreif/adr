<?php

namespace App\Admin\Responders;

use App\Admin\Domain\Resources\AdminLiteResource;
use App\Admin\Domain\Resources\AdminResource;
use App\Infrastructure\Helpers\Traits\ApiPaginator;
use App\Infrastructure\Helpers\Traits\RESTApi;
use App\Infrastructure\Responders\Responder;
use App\Infrastructure\Responders\ResponderInterface;
use Symfony\Component\HttpFoundation\Response;

class AdminResponder extends Responder implements ResponderInterface
{
    use RESTApi, ApiPaginator;

    public function respond()
    {

        if (! in_array($this->response->getStatus(), array_values(config('statuses.SUCCESS')))) {
            return $this->sendError($this->response->getData());
        }

        if ($this->response->getStatus() == Response::HTTP_CREATED) {
            return $this->sendJson(
                new AdminResource($this->response->getData()),
                Response::HTTP_OK
            );
        }

        if ($this->response->getStatus() == Response::HTTP_OK) {
            return $this->sendJson(
                AdminResource::collection($this->response->getData()),
                $this->response->getStatus()
            );
        }

        if ($this->response->getStatus() == Response::HTTP_ACCEPTED) {
            return $this->sendJson(
                $this->getPaginatedResponse(
                    $this->response->getData(),
                    AdminLiteResource::collection($this->response->getData())
                ), Response::HTTP_OK
            );
        }

        if ($this->response->getStatus() == Response::HTTP_NO_CONTENT) {
            return $this->sendJson($this->response->getData(), $this->response->getStatus());
        }

        if ($this->response->getStatus() == Response::HTTP_RESET_CONTENT) {
            return $this->response->getData();
        }

    }
}
