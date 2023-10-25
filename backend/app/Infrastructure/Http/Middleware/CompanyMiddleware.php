<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('company')->check() && Auth::guard('company')->user()->company_id == null) {
            return response()->json([
                'error' => __('error.unauthorized')
            ], 403);
        }

// if (Auth::guard('company')->user()->company->type != 'company' || Auth::guard('company')->user()->company->type != 'focus') {

//     return response()->json([

//         'error' => __('error.unauthorized'),

//     ], 403);
        // }

        return $next($request);
    }

}
