<?php

namespace App\Http\Controllers;
use App\Models\Ingresos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class IngresosController extends Controller
{  public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $ingresos = Ingresos::orderBy('fecha_hora_ingreso', 'desc')->paginate(10); // Cambia 10 por el número de registros que deseas mostrar por página.
        return view('Ingresos_index', ['ingresos' => $ingresos]);
    }


    public function filter(Request $request)
    {
        $query = Ingresos::query();
    
        // Filtrar por rango de fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $fechaInicio = date('Y-m-d H:i:s', strtotime($request->input('fecha_inicio')));
            $fechaFin = date('Y-m-d H:i:s', strtotime($request->input('fecha_fin') . ' 23:59:59'));
            $query->whereBetween('fecha_hora_ingreso', [$fechaInicio, $fechaFin]);
        }
    
        // Filtrar por usuario (correo)
        if ($request->filled('correo')) {
            $correo = $request->input('correo');
            $query->where('usuario', $correo);
        }
    
        // Aplicar paginación a los resultados filtrados
        $perPage = 10; // Cambia esto al número de registros por página que desees
        $ingresos = $query->paginate($perPage)->appends($request->query());
    
        return view('Ingresos_index', ['ingresos' => $ingresos]);
    }
}






