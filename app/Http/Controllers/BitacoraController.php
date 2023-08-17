<?php

namespace App\Http\Controllers;

use App\Models\bitacora;
use App\Models\tiquetes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bitacoras = Bitacora::paginate(10);
        return view('Bitacora_index', compact('bitacoras'));
    }

    public function filter(Request $request)
    {
        $query = Bitacora::query();

        // Filtrar por usuario
        if ($request->filled('usuario')) {
            $usuario = $request->input('usuario');
            $query->where('usuario', 'like', '%' . $usuario . '%');
        }

        // Filtrar por número de tiquete
        if ($request->filled('num_tiquete')) {
            $numTiquete = $request->input('num_tiquete');
            $query->where('num_tiquete', $numTiquete);
        }

         // Aplicar paginación a los resultados filtrados
         $perPage = 10; // Cambia esto al número de registros por página que desees
         $bitacoras = $query->paginate($perPage)->appends($request->query());
     
         return view('Bitacora_index', ['bitacoras' => $bitacoras]);
    }

    public function mostrarTiquetes()
    {
        $tiquetes = Tiquetes::all();
        $numerosTiquete = $tiquetes->pluck('num_caso');
    
        return view('Agregar_bitacora', ['numerosTiquete' => $numerosTiquete]);
    }

    public function store(Request $request)
    {
        $id = $request->id_bitacora;

        $existingBitacora = Bitacora::where('id_bitacora', $id)->first();

        if ($existingBitacora) {
            $errorMessage = 'La bitácora ya está registrada en la base de datos.';
            Session::flash('error', $errorMessage);
            return redirect()->back()->withInput();
        } else {
            $nombreUsuario = Auth::user()->nombre;

            Bitacora::create([
                'num_tiquete' => $request->input('num_caso'),
                'usuario' => $nombreUsuario,
                'comentario' => $request->comentario,
                'fecha_hora' => $request->fecha_hora,
                'fotografia' => $request->fotografia_equipo
            ]);
            return redirect()->route('Bitacora_index')->with('success', 'Entrada agregada correctamente.');
        }
    }

    public function destroy($id_bitacora)
{
    $bitacora = bitacora::findOrFail($id_bitacora);

    // Eliminar el rol
    $bitacora->delete();

    return redirect()->route('Bitacora_index')->with('success', 'Bitacora eliminada correctamente.');
}


}
