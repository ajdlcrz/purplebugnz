<?php

namespace App\Http\Middleware;

use Closure;

class HomePageAccess
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
        if (in_array('homepage', array_column(auth()->user()->role->modules, 'name'))) {
            return $next($request);
        }

        return abort(403);
    }
}
