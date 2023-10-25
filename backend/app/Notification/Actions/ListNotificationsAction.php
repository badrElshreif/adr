<?php

namespace App\Notification\Actions;

use App\Notification\Domain\Services\ListNotificationsService;
use App\Notification\Responders\NotificationResponder;
use Illuminate\Http\Request;

class ListNotificationsAction
{
    public function __construct(protected NotificationResponder $responder, protected ListNotificationsService $services)
    {
        $this->responder = $responder;
        $this->services  = $services;
    }

    public function __invoke(Request $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->all())
        )->respond();
    }
}
