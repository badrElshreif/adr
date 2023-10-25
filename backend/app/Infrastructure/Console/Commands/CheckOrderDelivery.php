<?php

namespace App\Infrastructure\Console\Commands;

use App\Admin\Domain\Models\Admin;
use App\Location\Domain\Models\Country;
use App\Notification\Domain\Notifications\OrderNotification;
use App\Order\Domain\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CheckOrderDelivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivery:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notify admin about orders with no delivery after x time from not respond';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $countries = Country::where('is_active', 1)->whereHas('states', function ($q)
        {
            $q->where('is_active', 1)
            //  ->where('sort', '!=', null)
                ->whereHas('cities', function ($q)
            {
                    $q->where('is_active', 1);
                });
        })->get();

        foreach ($countries as $country)
        {
            $delivery_wait_time = \setting('delivery_order_wait_time', $country->id);
            $date               = Carbon::now()->subMinutes($delivery_wait_time);

            $orders = Order::whereNull('delivery_id')->where('created_at', '<=', $date)->where('is_notify', 0)
                ->whereHas('status', function ($q)
            {
                    $q->whereIn('key', ['new', 'delayed']);
                })->get();

            $admins = Admin::where('is_active', 1)->whereNull('company_id')->get();

            foreach ($orders as $order)
            {
                $notif_data = [
                    'ar' => ['title' => 'طلب بدون توصيل', 'body' => 'يوجد طلب بدون مندوب توصيل رقم ' . $order->id],
                    'en' => ['title' => 'Order Without Delivery', 'body' => 'There Is Order Without Delivery Guy No ' . $order->id]
                ];
                Notification::send($admins, new OrderNotification($order, $notif_data));
                send_fcm_notification($admins,
                    [
                        'title'    => __('general.orders.order_without_delivery'),
                        'body'     => __('general.orders.order_without_delivery_msg') . $order->id,
                        'type'     => 'order',
                        'model_id' => $order->id
                    ],
                    true
                );
                $order->is_notify = 1;
                $order->save();
            }

        }

    }

}
