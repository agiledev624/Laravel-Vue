<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = \Auth::user();
        if ($user->role == $role) {
            return $next($request);
        }
        return redirect('/home');

        // if (! $request->user()->hasRole($role)) {
        //     abort(401, 'This action is unauthorized.');
        // }
        // return $next($request);
    }
}
