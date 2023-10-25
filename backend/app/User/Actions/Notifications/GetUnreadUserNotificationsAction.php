<?php

namespace App\User\Actions\Notifications;

use App\Notification\Responders\NotificationResponder;
use App\User\Domain\Services\Notifications\GetUnReadNotificationsCountService;

class GetUnreadUserNotificationsAction
{
    public function __construct(NotificationResponder $responder, GetUnReadNotificationsCountService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke()
    {
        return $this->responder->withResponse(
            $this->service->handle()
        )->respond();
    }
}
