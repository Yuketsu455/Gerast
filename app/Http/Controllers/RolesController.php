<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Permisos;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\usuarios;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $Roles = roles::paginate(10);
        return view('Roles_index', compact('Roles'));
    }

    public function filter(Request $request)
{
    $query = Roles::query();

    // Filtrar por nombre del rol
    if ($request->filled('nombre')) {
        $nombre = $request->input('nombre');
        $query->where('nombre', 'like', '%' . $nombre . '%');
    }

    // Obtener los registros filtrados con paginación
    // Aplicar paginación a los resultados filtrados
    $perPage = 10; // Cambia esto al número de registros por página que desees
    $Roles = $query->paginate($perPage)->appends($request->query());

    return view('Roles_index', ['Roles' => $Roles]);
}

    public function asignarPermisos($id)
    {
        $roles = Roles::findOrFail($id);
        $operaciones = Permisos::all();
        $modulos = Modulo::with('operaciones')->get();

        return view('asignar_permisos', compact('roles', 'operaciones','modulos'));
    }

    public function guardarPermisos(Request $request, $id)
    {
        $roles = Roles::findOrFail($id);
        $permisosSeleccionados = $request->input('permisos', []);

        $roles->Permisos()->sync($permisosSeleccionados);

        return redirect()->route('Roles_index')->with('success', 'Permisos asignados correctamente.');
    }
    
    public function store(Request $request)
    {
        $nombre = $request->nombre;

        // Verificar si el rol ya existe en la base de datos
        $existingRol = Roles::where('nombre', $nombre)->first();

        if ($existingRol) {
            // El rol ya existe, mostrar mensaje de error
            $errorMessage = 'El rol ya está registrado en la base de datos.';
            Session::flash('error', $errorMessage);

            // Redireccionar de vuelta al formulario con el mensaje de error
            return redirect()->back()->withInput();
        } else {
            // Generar un ID aleatorio único
            do {
                $randomId = rand(1000, 9999); // Generar un número aleatorio de 5 dígitos
            } while (DB::table('tbl_roles')->where('id', $randomId)->exists());

            $nuevoRol = Roles::create([
                'id' => $randomId,
                'nombre' => $nombre,
            ]);

            // Realizar otras acciones o redireccionar a otra vista
            $successMessage = 'Rol creado correctamente.';
            Session::flash('success', $successMessage);

            // Redireccionar de vuelta al formulario con el mensaje de éxito
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $rol = Roles::findOrFail($id);
    
        if ($id == 99) {
            return redirect()->route('Roles_index')->with('error', 'El rol de Super Usuario no puede ser eliminado.');
        }
    
        // Verificar si el rol está asignado a algún usuario
        if ($rol->usuarios->count() > 0) {
            return redirect()->route('Roles_index')->with('error', 'No se puede eliminar el rol porque está en uso.');
        }
    
        // Eliminar las relaciones en la tabla tbl_rol_operacion
        $rol->Permisos()->detach();
    
        // Eliminar el rol
        $rol->delete();
    
        return redirect()->route('Roles_index')->with('success', 'Rol eliminado correctamente.');
    }
}