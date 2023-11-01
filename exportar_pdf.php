<?php
require_once('tcpdf/tcpdf.php');
include 'config.php';

// Extiende la clase TCPDF
class PDF extends TCPDF {
    public function Header() {
        // Función para encabezado
        // Puedes personalizar el encabezado aquí
    }

    public function Footer() {
        // Función para pie de página
        // Puedes personalizar el pie de página aquí
    }
}

// Crear un nuevo objeto PDF
$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer metadatos
$pdf->SetCreator('Tu Nombre');
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Hoja de Presupuesto');
$pdf->SetSubject('Presupuesto para Cliente');

// Agregar una página
$pdf->AddPage();

// Configurar fuente y tamaño de texto
$pdf->SetFont('helvetica', '', 12);

// Información de la empresa y número de presupuesto
$pdf->Cell(0, 10, 'Empresa: Tu Empresa', 0, 1);
$pdf->Cell(0, 10, 'Número de Presupuesto: 001', 0, 1);
$pdf->Cell(0, 10, 'Fecha: ' . date('Y-m-d'), 0, 1);
$pdf->Cell(0, 10, 'Realizado por: Tu Nombre', 0, 1);

// Datos del cliente
$pdf->Cell(0, 10, 'Datos del Cliente:', 0, 1);
$pdf->Cell(0, 10, 'Empresa: Cliente XYZ', 0, 1);
$pdf->Cell(0, 10, 'Nombre: Nombre del Cliente', 0, 1);
$pdf->Cell(0, 10, 'Dirección: Dirección del Cliente', 0, 1);
$pdf->Cell(0, 10, 'Población: Población del Cliente', 0, 1);
$pdf->Cell(0, 10, 'Email: cliente@email.com', 0, 1);
$pdf->Cell(0, 10, 'Teléfono: 123-456-789', 0, 1);

// Selección de fabricante, serie y acabado
$pdf->Cell(0, 10, 'Seleccionar Fabricante: Fabricante XYZ', 0, 1);
$pdf->Cell(0, 10, 'Seleccionar Serie: Serie ABC', 0, 1);
$pdf->Cell(0, 10, 'Seleccionar Acabado: Acabado 123', 0, 1);

// Encabezado de la tabla de artículos
$pdf->Cell(30, 10, 'Unidades', 1);
$pdf->Cell(50, 10, 'Función', 1);
$pdf->Cell(50, 10, 'Referencia', 1);
$pdf->Cell(60, 10, 'Descripción', 1);
$pdf->Cell(40, 10, 'Precio Unidad', 1);
$pdf->Cell(40, 10, 'PVP Total', 1);
$pdf->Ln();  // Nueva línea

// Datos de artículos (esto debe ser un bucle que recorre los artículos)
$pdf->Cell(30, 10, '2', 1);
$pdf->Cell(50, 10, 'Artículo 1', 1);
$pdf->Cell(50, 10, 'REF-001', 1);
$pdf->Cell(60, 10, 'Descripción del artículo 1', 1);
$pdf->Cell(40, 10, '10.00', 1);
$pdf->Cell(40, 10, '20.00', 1);
$pdf->Ln();  // Nueva línea

$pdf->Cell(30, 10, '1', 1);
$pdf->Cell(50, 10, 'Artículo 2', 1);
$pdf->Cell(50, 10, 'REF-002', 1);
$pdf->Cell(60, 10, 'Descripción del artículo 2', 1);
$pdf->Cell(40, 10, '15.00', 1);
$pdf->Cell(40, 10, '15.00', 1);
$pdf->Ln();  // Nueva línea

// Cálculos de descuento, total PVP y precio neto total
$pdf->Cell(0, 10, 'Descuento: 5%', 0, 1);
$pdf->Cell(0, 10, 'Total PVP: 35.00', 0, 1);
$pdf->Cell(0, 10, 'Precio Neto Total: 33.25', 0, 1);

// Generar el PDF
$pdf->Output('presupuesto.pdf', 'I');
?>
