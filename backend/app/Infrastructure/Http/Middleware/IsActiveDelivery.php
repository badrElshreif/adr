<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Facades\Auth;

class IsActiveDelivery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd(auth()->user());
        if (auth('api')->check() && auth('api')->user()->type == 'delivery' && ! auth('api')->user()->delivery->is_active) {
            //dd(auth()->user()->is_active);
           // auth("api")->logout();
//            DB::table('device_tokens')->where('tokenable_type', 'App\User\Domain\Models\User')->where('tokenable_id', auth()->id())->delete();
            return response()->json([
                'error' => __('admin.max_wallet_limit'),
                //                  'is_blocked' => true
            ], 422);
        }

        return $next($request);
    }
}