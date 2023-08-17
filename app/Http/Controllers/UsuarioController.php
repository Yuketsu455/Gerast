<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios;
use App\Models\Roles;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Otros métodos del controlador...

    public function index()
    {
        $Usuarios = usuarios::paginate(10);
        return view('Usuario_index', compact('Usuarios'));
    }

    public function mostrarRoles()
    {
        $roles = Roles::all();
    
        // Roles que no deseas que aparezcan en el select
        $rolesNoPermitidos = ['Super Usuario'];
    
        // Filtrar los roles para obtener solo los permitidos
        $rolesPermitidos = $roles->filter(function ($rol) use ($rolesNoPermitidos) {
            return !in_array($rol->nombre, $rolesNoPermitidos);
        });
    
        return view('Agregar_Usuario', ['roles' => $rolesPermitidos]);
    }
    public function filter(Request $request)
    {
        $query = Usuarios::query();
    
        // Filtrar por cédula
        if ($request->filled('cedula')) {
            $cedula = $request->input('cedula');
            $query->where('cedula', $cedula);
        }
    
        // Filtrar por nombre
        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('nombre', 'LIKE', '%' . $nombre . '%');
        }
    
        // Aplicar paginación a los resultados filtrados
        $perPage = 10; // Cambia esto al número de registros por página que desees
        $Usuarios = $query->paginate($perPage)->appends($request->query());
    
        return view('Usuario_index', ['Usuarios' => $Usuarios]);
    }

    public function mostrarRoles2()
    {
        $Roles = Roles::all(); // Obtener todos los roles de la tabla tbl_roles
        return view('Usuario_editar', ['Roles' => $Roles]);
    }

    public function deshabilitarUsuario(Request $request, $cedula)
    {
    
        // Verificar si el usuario que se intenta deshabilitar es el Super Usuario
        if ($cedula == 0) {
            return redirect()->route('Usuario_index')->with('error', 'No está permitido deshabilitar al Super Usuario.');
        }
    
        $usuario = usuarios::where('cedula', $cedula)->firstOrFail();
        $usuario->estatus = 'Inactivo';
        $usuario->save();
    
        return redirect()->route('Usuario_index')->with('success', 'Usuario deshabilitado exitosamente.');
    }

    public function habilitarUsuario(Request $request, $cedula)
{
    $usuario = Usuarios::where('cedula', $cedula)->firstOrFail();
    $usuario->estatus = 'Activo';
    $usuario->save();

    return redirect()->route('Usuario_index')->with('success', 'Usuario habilitado exitosamente.');
}

    public function store(Request $request)
    {
        $cedula = $request->cedula;

        // Verificar si la cédula ya existe en la base de datos
        $existingUsuario = usuarios::where('cedula', $cedula)->first();
    
        if ($existingUsuario) {
            // La cédula ya existe, mostrar mensaje de error
            $errorMessage = 'La cédula ya está registrada en la base de datos.';
            Session::flash('error', $errorMessage);
    
            // Redireccionar de vuelta al formulario con el mensaje de error
            return redirect()->back()->withInput();
        } else {
        $nuevoUsuario = Usuarios::create([
        'nombre' => $request->nombre,
        'apellidos' => $request->apellidos,
        'cedula' => $request->cedula,
        'correo' => $request->correo,
        'contraseña' => $request->password,
        'fecha_nacimiento' => $request->fecha_nacimiento,
        'telefono' => $request->telefono,
        'fotografia' => $request->fotografia,
        'idrol' => $request->input('idrol'),
        'estatus' => $request->input('estatus')
        ]);
         // Mostrar mensaje de éxito
         $successMessage = 'Usuario creado correctamente.';
         Session::flash('success', $successMessage);
 
         // Redireccionar de vuelta al formulario con el mensaje de éxito
         return redirect()->back();
    }
    }

    public function edit($cedula)
    {
            $usuario = usuarios::where('cedula', $cedula)->first();
        if (!$usuario) {
            return redirect()->route('Agregar_Usuario')->with('error', 'Usuario no encontrado');
        }
        if ($usuario->cedula == 0) {
            return redirect()->route('Usuario_index')->with('error', 'No está permitido actualizar al Super Usuario.');
        }

        $roles = Roles::all(); // Obtener todos los roles
        return view('Usuario_editar', compact('usuario', 'roles'));

    }

    public function update(Request $request,$cedula)
{
    // Obtener el usuario a actualizar
    $usuario = Usuarios::where('cedula', $cedula)->firstOrFail();

    if ($usuario->cedula == 0) {
        return redirect()->route('Usuario_index')->with('error', 'No está permitido actualizar al Super Usuario.');
    }

    // Validar y actualizar los campos
    $usuario->nombre = $request->input('nombre');
    $usuario->apellidos = $request->input('apellidos');
    $usuario->correo = $request->input('correo');
    $usuario->contraseña = $request->input('password');
    $usuario->fecha_nacimiento = $request->input('fecha_nacimiento');
    $usuario->telefono = $request->input('telefono');
    $usuario->fotografia = $request->fotografia;
    $usuario->idrol = $request->input('idrol');
    $usuario->estatus = $request->input('estatus');

    // Guardar los cambios
    $usuario->save();

    // Mostrar mensaje de éxito
    $successMessage = 'Usuario actualizado correctamente.';
    Session::flash('success', $successMessage);

    // Redireccionar de vuelta al formulario con el mensaje de éxito
    return redirect()->back();
}
}

