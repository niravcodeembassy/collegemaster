<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(Auth::check() && $request->user()->is_active !== NUll) {
            \Auth::logout();
            return redirect('/')->with('error','Your account is not active please contact to admin');
        }
        return $next($request);
    }
}
