<?php

namespace App\Notification\Domain\Services;

use App\Company\Domain\Models\CompanyAdmin;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Notification\Domain\Filters\NotificationFilter;
use App\Notification\Domain\Models\Notification;
use Symfony\Component\HttpFoundation\Response;

class ListNotificationsService extends Service
{
    protected $notification;

    protected $filter;

    protected $type;

    public function __construct(Notification $notification, NotificationFilter $filter)
    {
        $this->notification = $notification;
        $this->filter       = $filter;
        $this->type         = request('type');
    }

    public function handle($data = [])
    {
        $query = Notification::where('type', 'App\Notification\Domain\Notifications\GeneralNotification')->filter($this->filter);

        $notifications = $query
            ->when(request('notification_type') == "company", function ($q)
        {
                $companies = CompanyAdmin::pluck('id')->toArray();
                $q->whereIn('notifiable_id', $companies)->where('notifiable_type', get_class(new CompanyAdmin()));
            })->groupBy('data')->orderBy('created_at', 'desc')->paginate(10);

        $this->readNotifications($notifications);

        return new GenericPayload($notifications, Response::HTTP_ACCEPTED);
    }

    public function readNotifications($notifications)
    {

        foreach ($notifications as $notification)
        {
            $notification->markAsRead();
        }

    }

}
