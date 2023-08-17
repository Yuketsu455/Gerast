<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCPDF;
use App\Models\Ingresos;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function generarPDF(Request $request)
    {
        // Obtener los datos filtrados (fechas y correo) desde el Request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $correo = $request->input('correo');

        // Obtener la consulta base de ingresos
        $query = Ingresos::query();

        // Filtrar por rango de fechas
        if ($fechaInicio && $fechaFin) {
            $fechaInicio = date('Y-m-d H:i:s', strtotime($fechaInicio));
            $fechaFin = date('Y-m-d H:i:s', strtotime($fechaFin . ' 23:59:59'));
            $query->whereBetween('fecha_hora_ingreso', [$fechaInicio, $fechaFin]);
        }

        // Filtrar por usuario (correo)
        if ($correo) {
            $query->where('usuario', $correo);
        }

        // Obtener los ingresos filtrados con las columnas requeridas
        $ingresos = $query->select('cod_movimiento', 'usuario', 'fecha_hora_ingreso', 'fecha_hora_salida')->get();

     // Generar el PDF utilizando la librería TCPDF
     $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
     $pdf->SetTitle('Reporte de Ingresos');
     $pdf->SetPrintHeader(true); // Habilitar encabezado en todas las páginas
     $pdf->SetPrintFooter(true); // Habilitar pie de página en todas las páginas
     $pdf->SetMargins(10, 30, 10); // Márgenes (izquierda, arriba, derecha)
     $pdf->AddPage();

     // Estilo para el encabezado del título
     $pdf->SetFont('helvetica', 'B', 16);
     $pdf->Cell(0, 10, 'Reporte de Ingresos', 0, 1, 'C');

     // Estilo para la fecha y hora de generación
     $pdf->SetFont('helvetica', 'I', 10);
     $pdf->Cell(0, 10, 'Fecha y Hora de Generación: ' . now(), 0, 1, 'R');

     // Información de usuario logueado
     $usuarioLogueado = Auth::user()->correo; // Cambia "nombre" por el atributo correcto
     $pdf->SetFont('helvetica', 'B', 12);
     $pdf->Cell(0, 10, 'Usuario: ' . $usuarioLogueado, 0, 1, 'L');

     $totalDatos = 0;

     // Tabla de datos (encabezado)
     $pdf->SetFont('helvetica', 'B', 10);
     $pdf->SetFillColor(200, 220, 240);
     $pdf->SetDrawColor(128, 128, 128);
     $pdf->Cell(30, 10, 'Código', 1, 0, 'C', 1);
     $pdf->Cell(50, 10, 'Usuario', 1, 0, 'C', 1);
     $pdf->Cell(40, 10, 'Fecha de Ingreso', 1, 0, 'C', 1);
     $pdf->Cell(40, 10, 'Hora de Ingreso', 1, 0, 'C', 1);
     $pdf->Cell(40, 10, 'Fecha de Salida', 1, 0, 'C', 1);
     $pdf->Cell(40, 10, 'Hora de Salida', 1, 1, 'C', 1);

     // Contenido de la tabla
     foreach ($ingresos as $ingreso) {
        $totalDatos++;
        $pdf->Cell(30, 10, $ingreso->cod_movimiento, 1, 0, 'C', 0);
        $pdf->Cell(50, 10, $ingreso->usuario, 1, 0, 'C', 0);
        $pdf->Cell(40, 10, date('d/m/Y', strtotime($ingreso->fecha_hora_ingreso)), 1, 0, 'C', 0);
        $pdf->Cell(40, 10, date('H:i:s', strtotime($ingreso->fecha_hora_ingreso)), 1, 0, 'C', 0);
        
        if (!empty($ingreso->fecha_hora_salida)) {
            // Si la fecha de salida no está vacía, mostrar la hora
            $pdf->Cell(40, 10, date('d/m/Y', strtotime($ingreso->fecha_hora_salida)), 1, 0, 'C', 0);
            $pdf->Cell(40, 10, date('H:i:s', strtotime($ingreso->fecha_hora_salida)), 1, 1, 'C', 0);
        } else {
            // Si la fecha de salida está vacía, mostrar "No registrado"
            $pdf->Cell(40, 10, 'No registrado', 1, 0, 'C', 0);
            $pdf->Cell(40, 10, 'No registrado', 1, 1, 'C', 0);
        }
    }

     // Agregar el total de datos registrados al encabezado del PDF
     $pdf->SetFont('helvetica', 'B', 12);
     $pdf->Cell(0, 10, 'Total de datos registrados: ' . $totalDatos, 0, 1, 'L');

     // Pie de página (número de página)
     $pdf->SetY(-50); // Posición a 15 mm desde el final
     $pdf->SetFont('helvetica', 'I', 8);
     $pdf->Cell(0, 10, 'Página ' . $pdf->getAliasNumPage() . ' de ' . $pdf->getAliasNbPages(), 0, 0, 'C');

     // Devolver el PDF como una descarga
     $pdf->Output('ingresos.pdf', 'D');
 }
}