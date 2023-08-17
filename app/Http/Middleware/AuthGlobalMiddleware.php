<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthGlobalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // El usuario está autenticado, permite continuar con la solicitud
            return $next($request);
        }

        // El usuario no está autenticado, redirige al formulario de login
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página');
    }
}


