<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        $user = auth()->user();
    
        if (!$user || !$user->rol) {
            return redirect()->route('welcome')->with('error', 'No tiene permisos suficientes.');
        }
    
        // Verificar si el usuario tiene el rol de "Super Administrador" (idrol = 99)
        if ($user->idrol === 99) {
            return $next($request);
        }
    
        // Verificar si la combinación idRol e idOperacion requerida existe en la relación
        $hasPermission = $user->rol->permisos()->where('idOperacion', $permission)->exists();
    
        if (!$hasPermission) {
            return redirect()->route('welcome')->with('error', 'No tiene permisos suficientes para realizar esta acción.');
        }
    
        // Si el usuario tiene el permiso, permite el acceso
        return $next($request);
    }
}