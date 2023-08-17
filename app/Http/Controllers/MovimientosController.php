<?php

namespace App\Http\Controllers;

use App\Models\Movimientos;
use Illuminate\Http\Request;

class MovimientosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $movimientos = Movimientos::orderBy('fecha_hora_mov', 'desc')->paginate(10);
        return view('Movimientos_index', compact('movimientos'));
    }

    public function filter(Request $request)
    {
        $query = Movimientos::query();
    
        if ($request->filled('fecha_inicio')) {
            $fechaInicio = date('Y-m-d H:i:s', strtotime($request->input('fecha_inicio')));
    
            if ($request->filled('fecha_fin')) {
                $fechaFin = date('Y-m-d H:i:s', strtotime($request->input('fecha_fin') . ' 23:59:59'));
                $query->whereBetween('fecha_hora_mov', [$fechaInicio, $fechaFin]);
            } else {
                // Si solo se proporciona la fecha de inicio, filtramos registros para ese día
                $query->whereDate('fecha_hora_mov', '=', $fechaInicio);
            }
        }
    
        // Resto de los filtros (correo, tipo_movimiento)
        if ($request->filled('correo')) {
            $correo = $request->input('correo');
            $query->where('usuario', $correo);
        }
    
        if ($request->filled('tipo_movimiento')) {
            $tipoMovimiento = $request->input('tipo_movimiento');
            $trimmedTipoMovimiento = trim($tipoMovimiento);
            $query->where('tipo_mov', 'LIKE', '%' . $trimmedTipoMovimiento . '%');
        }
    
        $perPage = 10;
        $movimientos = $query->paginate($perPage)->appends($request->query());
    
        return view('Movimientos_index', ['movimientos' => $movimientos]);
    }
}
