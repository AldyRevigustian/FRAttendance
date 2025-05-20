<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard('web')->check()) {
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
