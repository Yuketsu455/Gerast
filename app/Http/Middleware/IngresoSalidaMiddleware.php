<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Ingresos;
use Illuminate\Support\Facades\Auth;

class IngresoSalidaMiddleware
{
    public function handle($request, Closure $next)
    {
        // Si el usuario está autenticado (ha hecho login)
        if (Auth::check()) {
            // Obtener el correo del usuario autenticado
            $usuarioCorreo = Auth::user()->correo;

            // Verificar si ya se registró el ingreso del usuario en esta sesión
            if (!$request->session()->has('ingreso_registrado')) {
                // Buscar un registro de ingreso sin fecha de salida para el usuario
                $ingreso = Ingresos::where('usuario', $usuarioCorreo)->whereNull('fecha_hora_salida')->first();

                // Si no se encuentra un registro de ingreso sin fecha de salida, crear uno nuevo
                if (!$ingreso) {
                    Ingresos::create([
                        'usuario' => $usuarioCorreo,
                        'fecha_hora_ingreso' => now(),
                    ]);
                }

                // Marcar que ya se registró el ingreso para esta sesión
                $request->session()->put('ingreso_registrado', true);
            }
        }

        return $next($request);
    }
}