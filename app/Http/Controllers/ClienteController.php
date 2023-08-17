<?php

namespace App\Http\Controllers;

use App\Models\tiquetes;
use App\Models\clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
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
        $Clientes = clientes::paginate(10);
        return view('Cliente_index', compact('Clientes'));
    }

    public function filter(Request $request)
    {
        $query = Clientes::query();
    
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
    
        // Obtener los registros filtrados con paginación
         // Aplicar paginación a los resultados filtrados
         $perPage = 10; // Cambia esto al número de registros por página que desees
         $Clientes = $query->paginate($perPage)->appends($request->query());
     
         return view('Cliente_index', ['Clientes' => $Clientes]);
    }

    public function store(Request $request)
    {$cedula = $request->cedula;

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'apellidos' => 'required|alpha',
            'cedula' => 'required|numeric|regex:/^\d+$/',
            'correo' => 'required|email',
            'telefono' => 'required|numeric|regex:/^\d+$/',
        ]);

        // Verificar si la cédula ya existe en la base de datos
        $existingCliente = clientes::where('cedula', $cedula)->first();
    
        if ($existingCliente) {
            // La cédula ya existe, mostrar mensaje de error
            $errorMessage = 'La cédula ya está registrada en la base de datos.';
            Session::flash('error', $errorMessage);
    
            // Redireccionar de vuelta al formulario con el mensaje de error
            return redirect()->back()->withInput();
        } else {
            // La cédula no existe, proceder a crear el nuevo registro
            clientes::create([
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'cedula' => $cedula,
                'correo' => $request->correo,
                'telefono' => $request->telefono
            ]);
    
            // Mostrar mensaje de éxito
            $successMessage = 'Cliente creado correctamente.';
            Session::flash('success', $successMessage);
    
            // Redireccionar de vuelta al formulario con el mensaje de éxito
            return redirect()->back();
        }
    }

    public function edit($cedula)
    {
        $cliente = clientes::where('cedula', $cedula)->first();
    if (!$cliente) {
        return redirect()->route('Agregar_cliente')->with('error', 'Cliente no encontrado');
    }

    return view('Cliente_editar', compact('cliente'));
    }

    public function update(Request $request,$cedula)
    {
        $cliente = clientes::where('cedula', $cedula)->first();
    if (!$cliente) {
        return redirect()->route('Agregar_cliente')->with('error', 'Cliente no encontrado');
    }

    // Actualizar los datos del cliente con los valores del formulario
    $cliente->nombre = $request->input('nombre');
    $cliente->apellidos = $request->input('apellidos');
    $cliente->correo = $request->input('correo');
    $cliente->telefono = $request->input('telefono');
    // Actualiza los demás campos del cliente aquí

    $cliente->save();

    return redirect()->route('Cliente_index')->with('success', 'Cliente actualizado correctamente');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cedula)
    {
        $cliente = Clientes::where('cedula', $cedula)->first();

    if (!$cliente) {
        return redirect()->route('Cliente_index')->with('error', 'Cliente no encontrado');
    }

    $tieneTiquetes = Tiquetes::where('id_cliente', $cliente->cedula)->exists();

    if ($tieneTiquetes) {
        return redirect()->route('Cliente_index')->with('error', 'El cliente tiene tiquetes asociados y no puede ser eliminado');
    }

    $cliente->delete();

    return redirect()->route('Cliente_index')->with('success', 'Cliente eliminado correctamente');
    }
}
