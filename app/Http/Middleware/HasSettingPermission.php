<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HasSettingPermission
{
    public function handle($request, Closure $next)
    {
        return $next($request);
        if (Auth::guard('admin')->user()->hasRole('admin')) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');

    }
}
