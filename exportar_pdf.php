<?php
require_once('tcpdf/tcpdf.php');
include 'config.php';

$pdf = new TCPDF();

$pdf->AddPage();

$html = '<h1>Lista de Presupuestos</h1>';

$html .= '<table>';
$html .= '<tr>';
$html .= '<th>ID</th>';
$html .= '<th>Cliente</th>';
$html .= '<th>Descripción</th>';
$html .= '<th>Monto</th>';
$html .= '<th>Fecha</th>';
$html .= '</tr>';

$sql = "SELECT * FROM presupuestos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row["id"] . '</td>';
        $html .= '<td>' . $row["cliente"] . '</td>';
        $html .= '<td>' . $row["descripcion"] . '</td>';
        $html .= '<td>' . $row["monto"] . '</td>';
        $html .= '<td>' . $row["fecha"] . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="5">No se encontraron presupuestos</td>';
    $html .= '</tr>';
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('lista_presupuestos.pdf', 'D');
?>
