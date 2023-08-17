<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCPDF;
use App\Models\clientes;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;

class PDFClientesController extends Controller
{
    public function generarPDF(Request $request)
    {

        $query = clientes::query();

        // Filtrar por usuario (correo)
        if ($request->filled('cedula')) {
            $cedula = $request->input('cedula');
            $query->where('cedula', $cedula);
        }
    
        // Filtrar por nombre
        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('nombre', 'LIKE', '%' . $nombre . '%');
        }

         // Obtener los ingresos filtrados con las columnas requeridas
         $Clientes = $query->select('nombre', 'apellidos', 'cedula', 'correo','telefono')->get();

        // Obtener el nombre del usuario autenticado
        $usuarioLogueado = Auth::user()->correo; // Cambia "nombre" por el atributo correcto
        
        $totalDatos = 0;

        // Generar el PDF utilizando la librería TCPDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Reporte de Clientes');
        $pdf->SetPrintHeader(true); // Habilitar encabezado en todas las páginas
        $pdf->SetPrintFooter(true); // Habilitar pie de página en todas las páginas
        $pdf->SetMargins(10, 30, 10); // Márgenes (izquierda, arriba, derecha)
        $pdf->AddPage();

        // Estilo para el encabezado del título
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Clientes', 0, 1, 'C');

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
        $pdf->Cell(30, 10, 'Nombre', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Apellido', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Cédula', 1, 0, 'C', 1);
        $pdf->Cell(50, 10, 'Correo Electrónico', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Teléfono', 1, 1, 'C', 1);

        // Contenido de la tabla
        foreach ($Clientes as $cliente) {

            $totalDatos++;
            $pdf->Cell(30, 10, $cliente->nombre, 1, 0, 'C', 0);
            $pdf->Cell(30, 10, $cliente->apellidos, 1, 0, 'C', 0);
            $pdf->Cell(30, 10, $cliente->cedula, 1, 0, 'C', 0);
            $pdf->Cell(50, 10, $cliente->correo, 1, 0, 'C', 0);
            $pdf->Cell(30, 10, $cliente->telefono, 1, 1, 'C', 0);
        }

         // Agregar el total de datos registrados al encabezado del PDF
         $pdf->SetFont('helvetica', 'B', 12);
         $pdf->Cell(0, 10, 'Total de datos registrados: ' . $totalDatos, 0, 1, 'L');

        // Pie de página (número de página)
        $pdf->SetY(-50); // Posición a 15 mm desde el final
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->Cell(0, 10, 'Página ' . $pdf->getAliasNumPage() . ' de ' . $pdf->getAliasNbPages(), 0, 0, 'C');

        // Devolver el PDF como una descarga
        $pdf->Output('clientes.pdf', 'D');
    }
}
