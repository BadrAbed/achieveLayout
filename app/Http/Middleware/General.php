<?php

namespace App\Http\Middleware;

use Closure;

class General
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

        if (auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT || auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR || auth()->user()->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER) {
            return redirect('notAllowed');
        }
        return $next($request);
    }
}
