<?php

namespace App\Http\Middleware;

use Closure;

class isCSR {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (auth()->user()->access_type <> -1) {
            return back()->with('status', 'Sorry you are not authorized');
        }
        return $next($request);
    }

}
