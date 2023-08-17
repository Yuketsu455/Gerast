<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCPDF;
use App\Models\bitacora;
use Illuminate\Support\Facades\Auth;

class PDFBitacoraController extends Controller
{
    public function generarPDF(Request $request)
    {

        $query = bitacora::query();

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

         // Obtener los ingresos filtrados con las columnas requeridas
         $bitacoras = $query->select('id_bitacora', 'num_tiquete', 'usuario', 'comentario','fecha_hora')->get();

        // Obtener el nombre del usuario autenticado
        $usuarioLogueado = Auth::user()->correo; // Cambia "nombre" por el atributo correcto
        
        $totalDatos = 0;

        // Generar el PDF utilizando la librería TCPDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Reporte Bitacoras');
        $pdf->SetPrintHeader(true); // Habilitar encabezado en todas las páginas
        $pdf->SetPrintFooter(true); // Habilitar pie de página en todas las páginas
        $pdf->SetMargins(10, 30, 10); // Márgenes (izquierda, arriba, derecha)
        $pdf->AddPage();

        // Estilo para el encabezado del título
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Bitacoras', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Satellite', 0, 1, 'C');

        // Estilo para la fecha y hora de generación
        $pdf->SetFont('helvetica', 'I', 10);
        $pdf->Cell(0, 10, 'Fecha y Hora de Generación: ' . now(), 0, 1, 'R');

        // Información de usuario logueado
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Usuario: ' . $usuarioLogueado, 0, 1, 'L');

        // Tabla de datos (encabezado)
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(200, 220, 240);
        $pdf->SetDrawColor(128, 128, 128);
        $pdf->Cell(30, 10, 'ID', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Numero de Tiquete', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Usuario', 1, 0, 'C', 1);
        $pdf->Cell(130, 10, 'Comentario', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Fecha y Hora', 1, 1, 'C', 1);

        // Contenido de la tabla
        foreach ($bitacoras as $bitacora) {

            $totalDatos++;
            $pdf->Cell(30, 10, $bitacora->id_bitacora, 1, 0, 'C', 0);
            $pdf->Cell(40, 10, $bitacora->num_tiquete, 1, 0, 'C', 0);
            $pdf->Cell(40, 10, $bitacora->usuario, 1, 0, 'C', 0);
            $pdf->Cell(130, 10, $bitacora->comentario, 1, 0, 'C', 0);
            $pdf->Cell(40, 10, $bitacora->fecha_hora, 1, 1, 'C', 0);
        }

        // Agregar el total de datos registrados al encabezado del PDF
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, 'Total de datos registrados: ' . $totalDatos, 0, 1, 'L');

        // Pie de página (número de página)
        $pdf->SetY(-50); // Posición a 15 mm desde el final
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->Cell(0, 10, 'Página ' . $pdf->getAliasNumPage() . ' de ' . $pdf->getAliasNbPages(), 0, 0, 'C');

        // Devolver el PDF como una descarga
        $pdf->Output('bitacorass.pdf', 'D');
    }
}
