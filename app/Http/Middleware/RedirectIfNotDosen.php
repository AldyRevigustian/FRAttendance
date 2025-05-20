<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotDosen
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard('dosen')->check()) {
            return redirect()->route('dosen.login');
        }
        return $next($request);
    }
}
