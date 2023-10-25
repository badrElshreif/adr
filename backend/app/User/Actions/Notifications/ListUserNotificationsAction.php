<?php

namespace App\User\Actions\Notifications;

use App\Notification\Responders\NotificationResponder;
use App\User\Domain\Requests\NotificationFormRequest;
use App\User\Domain\Services\Notifications\ListUserNotificationsService;

class ListUserNotificationsAction
{
    public function __construct(NotificationResponder $responder, ListUserNotificationsService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(NotificationFormRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
