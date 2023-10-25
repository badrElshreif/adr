<?php

namespace App\Notification\Actions;

use App\Notification\Domain\Services\ReadNotificationService;
use App\Notification\Responders\NotificationResponder;

class ReadNotificationAction
{
    public function __construct(NotificationResponder $responder, ReadNotificationService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id)
    {
        return $this->responder->withResponse(
            $this->services->handle(['notification_id' => $id])
        )->respond();
    }
}
