<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isAdmin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::user()->access_type != 1) {

            return response('Unauthorized.', 401);
        }

        return $next($request);
    }

}
