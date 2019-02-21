<?php

namespace App\Http\Middleware;

use Closure;

class QuestionsEditor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        $conditions = auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER;

        if (!$role) {
            if ($conditions) {
                return redirect('notAllowed');
            }
        } elseif ($role && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER&&$conditions) {
            return redirect('notAllowed');
        }
        return $next($request);
    }
}
