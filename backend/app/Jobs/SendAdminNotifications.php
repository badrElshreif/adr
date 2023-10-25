<?php

namespace App\Jobs;

use App\Order\Domain\Services\OrderHelperService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $order;
    protected $msg;
    public function __construct($order, $msg)
    {
        $this->order              = $order;
        $this->msg                = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        app(OrderHelperService::class)->notify_admins($this->order, $this->msg); // notify super admin and scope admins
        app(OrderHelperService::class)->sendToAdminsOnOrderScope($this->order, $this->msg); // send to admins on order scope (city)
        app(OrderHelperService::class)->sendToStore($this->order, $this->msg); // send to admins on order scope (city)
    }
}
