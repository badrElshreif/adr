<?php

namespace App\Infrastructure\Console\Commands;

use App\Location\Domain\Models\Country;
use App\Order\Domain\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateOrderStatusDelayed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:delayed';

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
        cache()->forget('settings');
        $countries = Country::where('is_active', 1)->whereHas('states', function ($q) {
            $q->where('is_active', 1)
              //  ->where('sort', '!=', null)
                ->whereHas('cities', function ($q) {
                    $q->where('is_active', 1);
                });
            })->get();

        foreach ($countries as $country) {
            $delivery_wait_time = \setting('max_time_before_delayed', $country->id);
            if (!$delivery_wait_time) {
                return;
            }
            $date   = Carbon::now()->timezone('Asia/Riyadh')->subMinutes($delivery_wait_time);
            $orders = Order::query()->withoutGlobalScopes()->whereNull('delivery_id')->where('delivery_date', '<=', $date)
                ->whereHas('status', function ($q) {
                    $q->where('key', 'new');
                });
            $status_delayed = \status('order', 'delayed');
            if ($status_delayed) {
                $orders->update(['status_id' => $status_delayed]);
            }
        }
    }
}
