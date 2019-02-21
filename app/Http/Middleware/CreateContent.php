<?php

namespace App\Http\Middleware;

use Closure;

class CreateContent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER) {
            return redirect('notAllowed');
        }
        return $next($request);
    }
}
