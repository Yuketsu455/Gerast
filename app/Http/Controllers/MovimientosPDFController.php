<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCPDF;
use App\Models\Movimientos;
use Illuminate\Support\Facades\Auth;

class MovimientosPDFController extends Controller
{
    public function generarPDF(Request $request)
    {
        // Obtener los datos filtrados (fechas, correo y tipo de movimiento) desde el Request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $correo = $request->input('correo');
        $tipoMovimiento = $request->input('tipo_movimiento');

        // Obtener la consulta base de movimientos
        $query = Movimientos::query();

        // Filtrar por rango de fechas
        if ($fechaInicio && $fechaFin) {
            $fechaInicio = date('Y-m-d H:i:s', strtotime($fechaInicio));
            $fechaFin = date('Y-m-d H:i:s', strtotime($fechaFin . ' 23:59:59'));
            $query->whereBetween('fecha_hora_mov', [$fechaInicio, $fechaFin]);
        }

        // Filtrar por usuario (correo)
        if ($correo) {
            $query->where('usuario', $correo);
        }

        // Filtrar por tipo de movimiento (conteniendo "Insertar en", "Editar en" o "Eliminar en")
        if ($tipoMovimiento) {
            $query->where('tipo_mov', 'LIKE', '%' . $tipoMovimiento . '%');
        }

        // Obtener los movimientos filtrados con las columnas requeridas
        $movimientos = $query->select('cod_movimiento', 'usuario', 'fecha_hora_mov', 'tipo_mov', 'detalle')->get();
        
        $totalDatos = 0;

               // Generar el reporte PDF utilizando la librería TCPDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        // Establecer el título del documento
        $pdf->SetTitle('Reporte de Movimientos');

        // Agregar una página al PDF
        $pdf->AddPage();

        // Información de usuario logueado
        $usuarioLogueado = Auth::user()->correo; // Cambia "correo" por el atributo correcto
        $pdf->Cell(0, 10, 'Reporte de Movimientos', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Usuario: ' . $usuarioLogueado, 0, 1, 'L');
        $pdf->SetFont('helvetica', 'I', 10);
        $pdf->Cell(0, 10, 'Fecha y Hora de Generación: ' . now(), 0, 1, 'L');
       
    
               // Construir la tabla de movimientos
               $pdf->SetFont('helvetica', '', 10);
               $pdf->SetFillColor(240, 240, 240);
               $pdf->SetDrawColor(128, 128, 128);
               $pdf->Cell(30, 10, 'Código', 1, 0, 'C', 1);
               $pdf->Cell(50, 10, 'Usuario', 1, 0, 'C', 1);
               $pdf->Cell(40, 10, 'Fecha de movimiento', 1, 0, 'C', 1);
               $pdf->Cell(50, 10, 'Tipo de movimiento', 1, 0, 'C', 1);
               $pdf->Cell(110, 10, 'Detalle', 1, 1, 'C', 1);
       
               // Contenido de la tabla
               foreach ($movimientos as $movimiento) {

                 $totalDatos++;
                   $pdf->Cell(30, 10, $movimiento->cod_movimiento, 1, 0, 'C', 0);
                   $pdf->Cell(50, 10, $movimiento->usuario, 1, 0, 'C', 0);
                   $pdf->Cell(40, 10, $movimiento->fecha_hora_mov, 1, 0, 'C', 0);
                   $pdf->Cell(50, 10, $movimiento->tipo_mov, 1, 0, 'C', 0);
                   $pdf->Cell(110, 10, $movimiento->detalle, 1, 1, 'C', 0);
               }

                // Agregar el total de datos registrados al encabezado del PDF
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Total de datos registrados: ' . $totalDatos, 0, 1, 'L');
       
               // Número de página en cada página
               $pdf->SetY(-50);
               $pdf->SetFont('helvetica', '', 8);
               $pdf->Cell(0, 10, 'Página ' . $pdf->getAliasNumPage() . ' de ' . $pdf->getAliasNbPages(), 0, 0, 'C');
       
               // Devolver el PDF como una descarga
               $pdf->Output('movimientos.pdf', 'D');
           }
}
