<?php

namespace App\Http\Middleware;

use Closure;

class School
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard=null)
    {

        return $next($request);
    }
}
