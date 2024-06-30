<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticateFrontend
{
    public function handle(Request $request, Closure $next)
    {
        if ( (Auth::guard('users')->check() || Auth::guard('customers')->check())) {
            return $next($request);
        }

        return redirect('/category');
    }
}
