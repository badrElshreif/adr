<?php

namespace App\AppContent\Domain\Services\Statistics;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Order\Domain\Models\Order;
use App\Product\Domain\Models\Product;
use Illuminate\Support\Arr;
use App\Admin\Domain\Models\Role;
use App\Store\Domain\Models\CenterAdmin;
use App\Store\Domain\Models\StoreAdmin;
use Symfony\Component\HttpFoundation\Response;

class GetHomeService extends Service
{
    public function handle($data)
    {
        $statistics = [];
        $store_id = auth()->user()->store_id;

        $statistics['products'] = Product::active(1)
                    ->where('store_id', $store_id)
                    ->count();

        $statistics['orders'] = Order::
                    where('store_id', $store_id)
                    ->count();

        $statistics['balances'] = Order::
            where('is_paid', 1)
            ->where('store_id', $store_id)
            ->sum(\DB::raw('total - application_dues'));

        $statistics['balances'] = $statistics['balances'] > 0 ? number_format((float) $statistics['balances'], 2, '.', '') : "0.00";

        if (auth()->guard('store')->check()) {
            $admin = StoreAdmin::where('id', '!=', auth()->user()->id)->where('store_id', $store_id);
        } elseif (auth()->guard('center')->check()) {
            $admin = CenterAdmin::where('id', '!=', auth()->user()->id)->where('store_id', $store_id);
        }


        $statistics['roles'] = $admin->
            get()->map(function ($q) {
                return [
                    'name'      => $q->name,
                    'role'      => $q->roles()->first() ? $q->roles()->first()->display_name : '',
                    'is_active' => (bool) $q->is_active,
                ];
            });
        if (auth()->guard('store')->check()) {
            return new GenericPayload(Arr::only($statistics, ['products', 'orders','balances', 'roles']), Response::HTTP_RESET_CONTENT);
        } else {
            return new GenericPayload([], Response::HTTP_RESET_CONTENT);
        }

    }
}
