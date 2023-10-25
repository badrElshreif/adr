<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Delivery
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
        if (auth('api')->check() && ! auth('api')->user()->type == 'delivery') {
            return response()->json([
                'error' => __('error.unauthorized'),
            ], 403);

        }

        return $next($request);
    }
}
