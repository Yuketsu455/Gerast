<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use App\Models\Ingreso;
use App\Models\Ingresos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required',
        ]);

        $usuario = usuarios::where('correo', $credentials['correo'])->first();

        if ($usuario && $usuario->correo === 'super@gmail.com' && $credentials['contraseña'] === 'root') {
            // Autenticación exitosa para el superusuario
            Auth::login($usuario);
            return redirect()->route('welcome'); // Cambia esto a la ruta que prefieras
        }

        if (!$usuario || !Hash::check($credentials['contraseña'], $usuario->contraseña)) {
            return redirect()->route('login')->with('error', 'Credenciales inválidas');
        }

        // Verificar el estatus del usuario antes de permitir el inicio de sesión
        if ($usuario->estatus === 'Inactivo') {
            throw ValidationException::withMessages([
                'correo' => 'Su cuenta está inactiva. Contacte al administrador para obtener acceso.',
            ]);
        }

        Auth::login($usuario);

        // Crear registro de ingreso
        $ingreso = new Ingresos();
        $ingreso->usuario = $usuario->correo;
        $ingreso->fecha_hora_ingreso = now();
        $ingreso->save();

        return redirect()->route('welcome');
    }

    public function logout()
    {
        // Actualizar la hora de salida del registro de ingreso
        if (Auth::check()) {
            $usuarioCorreo = Auth::user()->correo;
            $ingreso = Ingresos::where('usuario', $usuarioCorreo)->whereNull('fecha_hora_salida')->first();
            if ($ingreso) {
                $ingreso->fecha_hora_salida = now();
                $ingreso->save();
            }
        }

        Auth::logout();
        return redirect('/login');
    }
}