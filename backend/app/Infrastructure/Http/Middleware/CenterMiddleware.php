<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CenterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // if (Auth::guard('center')->check() && Auth::guard('center')->user()->company_id == null) {
        //     return response()->json([
        //         'error' => __('error.unauthorized'),
        //     ], 403);
        // }
        // if (Auth::guard('center')->user()->store->type != 'focus') {
        //     return response()->json([
        //         'error' => __('error.unauthorized'),
        //     ], 403);
        // }

        return $next($request);
    }
}
