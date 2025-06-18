<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuditorRedirect
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'auditor') {
            return redirect()->route('auditor.inventario');
        }

        return $next($request);
    }
}