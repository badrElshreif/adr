<?php

namespace App\Admin\Actions\Notifications;

use App\Admin\Domain\Services\Notifications\ListUserNotificationsService;
use App\Notification\Responders\NotificationResponder;
use App\User\Domain\Requests\NotificationFormRequest;

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
