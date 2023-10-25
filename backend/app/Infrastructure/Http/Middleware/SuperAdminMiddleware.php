<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->company_id != null)
        {
            return response()->json([
                'error' => __('error.unauthorized')
            ], 403);
        }

        return $next($request);
    }

}
