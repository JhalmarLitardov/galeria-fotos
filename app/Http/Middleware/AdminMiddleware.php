<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Solo permitimos el acceso si es admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos de administrador.');
    }
}
