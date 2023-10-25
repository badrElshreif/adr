<?php

namespace App\Jobs;

use App\Order\Domain\Services\OrderHelperService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDeliveriesNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get country id for setting notifications
        $country_id = $this->order->store ? $this->order->store?->city?->country_id : City::find($this->order->store_city_id)?->country_id;
        app(OrderHelperService::class)->notify_deliveries($this->order, $country_id, true);
    }

}
