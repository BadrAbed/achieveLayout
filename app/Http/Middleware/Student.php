<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Auth;
use App\Http\OwnClasses\Permissions;
class Student
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {


        if (Permissions::STUDENT_PERMISSION_ENUM != auth()->user()->is_permission) {

            return redirect('notAllowed');
        }
        return $next($request);
    }
}
