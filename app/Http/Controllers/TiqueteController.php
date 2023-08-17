<?php

namespace App\Http\Controllers;

use App\Models\tiquetes;
use App\Models\clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\bitacora;

class TiqueteController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Tiquetes = tiquetes::paginate(10);
        return view('Tiquete_index', compact('Tiquetes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }
    public function mostrarFormulario()
    {
        $Clientes = clientes::all(); // Obtener todos los clientes de la tabla tbl_clientes

        return view('Agregar_Tiquete', ['Clientes' => $Clientes]);
        
    }
    public function mostrarFormulario2()
    {
        $Clientes = clientes::all(); // Obtener todos los clientes de la tabla tbl_clientes
        return view('Tiquete_editar', ['Clientes' => $Clientes]);
    }

    public function filter(Request $request)
{
    $query = Tiquetes::query();

    // Filtrar por número de caso
    if ($request->filled('num_caso')) {
        $numCaso = $request->input('num_caso');
        $query->where('num_caso', $numCaso);
    }

    // Filtrar por ID de cliente
    if ($request->filled('id_cliente')) {
        $idCliente = $request->input('id_cliente');
        $query->where('id_cliente', $idCliente);
    }

    // Filtrar por usuario
    if ($request->filled('usuario')) {
        $usuario = $request->input('usuario');
        $query->where('usuario', $usuario);
    }

    // Filtrar por prioridad
    if ($request->filled('prioridad')) {
        $prioridad = $request->input('prioridad');
        $query->where('prioridad', $prioridad);
    }

    // Filtrar por estado
    if ($request->filled('estado')) {
        $estado = $request->input('estado');
        $query->where('estado_tiquete', $estado);
    }

    // Aplicar paginación a los resultados filtrados
    $perPage = 10; // Cambia esto al número de registros por página que desees
    $Tiquetes = $query->paginate($perPage)->appends($request->query());

    return view('Tiquete_index', ['Tiquetes' => $Tiquetes]);
}
//Guarda los datos
    public function store(Request $request)
    {
        $num_caso = $request->num_caso;
    
        // Verificar si el tiquete ya existe en la base de datos
        $existingTiquete = Tiquetes::where('num_caso', $num_caso)->first();
    
        if ($existingTiquete) {
            // El tiquete ya existe, mostrar mensaje de error
            $errorMessage = 'El tiquete ya está registrado en la base de datos.';
            Session::flash('error', $errorMessage);
    
            // Redireccionar de vuelta al formulario con el mensaje de error
            return redirect()->back()->withInput();
        } else {
            // Obtener el nombre del usuario logueado
            $nombreUsuario = Auth::user()->nombre; // Ajusta esto según la estructura de tu tabla de usuarios
    
            // El tiquete no existe, proceder a crear el nuevo registro
            Tiquetes::create([
                'num_caso' => $num_caso,
                'tipo_equipo'=> $request->tipo_equipo,
                'id_cliente'=> $request->input('id_cliente'),
                'usuario'=> $nombreUsuario, // Asignar el nombre del usuario
                'marca'=> $request->marca,
                'modelo'=> $request->modelo,
                'serie'=> $request->serie,
                'cargador' => $request->input('cargador'),
                'garantia' => $request->input('garantia'),
                'fecha'=> $request->fecha_ingreso,
                'prioridad'=> $request->input('prioridad'),
                'estado_tiquete'=> $request->input('estado'),
                'fotografia'=> $request->fotografias,
            ]);
    
            // Mostrar mensaje de éxito
            $successMessage = 'Tiquete creado correctamente.';
            Session::flash('success', $successMessage);
    
            // Redireccionar de vuelta al formulario con el mensaje de éxito
            return redirect()->back();
        }
    }

    public function edit($num_caso)
    {
            $tiquete = tiquetes::where('num_caso', $num_caso)->first();
        if (!$tiquete) {
            return redirect()->route('Agregar_Tiquete')->with('error', 'Tiquete no encontrado');
        }

        return view('Tiquete_editar', compact('tiquete'));
    }
    

//Update
public function update(Request $request, $num_caso)
{
    $tiquete = tiquetes::where('num_caso', $num_caso)->first();
    if (!$tiquete) {
        return redirect()->route('Agregar_Tiquete')->with('error', 'Tiquete no encontrado');
    }

    // Actualizar los datos del tiquete con los valores del formulario
    $tiquete->tipo_equipo = $request->input('tipo_equipo');
    $tiquete->marca = $request->input('marca');
    $tiquete->modelo = $request->input('modelo');
    $tiquete->serie = $request->input('serie');
    $tiquete->cargador = $request->input('cargador');
    $tiquete->garantia = $request->input('garantia');
    $tiquete->prioridad = $request->input('prioridad');
    $tiquete->estado_tiquete = $request->input('estado');
    // Actualiza los demás campos del tiquete aquí

    $tiquete->save();

    return redirect()->route('Tiquete_index')->with('success', 'Tiquete actualizado correctamente');
}

public function destroy($num_caso)
{
    $tiquete = tiquetes::where('num_caso', $num_caso)->first();

    if (!$tiquete) {
        return redirect()->route('Tiquete_index')->with('error', 'Tiquete no encontrado');
    }
    
    // Verificar si el num_caso está en uso en la tabla bitacoras
    $bitacorasCount = Bitacora::where('num_tiquete', $num_caso)->count();
    
    if ($bitacorasCount > 0) {
        return redirect()->route('Tiquete_index')->with('error', 'No se puede eliminar porque se está usando el código en bitacoras');
    }

    $tiquete->delete();

    return redirect()->route('Tiquete_index')->with('success', 'Tiquete eliminado correctamente');
}
    
}