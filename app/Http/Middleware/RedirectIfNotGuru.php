<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotGuru
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard('guru')->check()) {
            return redirect()->route('guru.login');
        }
        return $next($request);
    }
}
