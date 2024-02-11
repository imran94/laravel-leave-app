<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsCSRAdmin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::user()->access_type <> 0) {

            return back()->with('status', 'Sorry you are not authorized');
        }

        return $next($request);
    }

}
