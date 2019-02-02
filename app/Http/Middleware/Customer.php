<?php

namespace App\Http\Middleware;

use Closure;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()) {
            if (auth()->user()->type == 'admin' or auth()->user()->type == 'customer') {
                return $next($request);
            }
        }
            return redirect('/sign');
    }
}
