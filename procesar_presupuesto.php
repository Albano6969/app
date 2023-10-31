<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente = $_POST["cliente"];
    $descripcion = $_POST["descripcion"];
    $monto = $_POST["monto"];

    $sql = "INSERT INTO presupuestos (cliente, descripcion, monto, fecha) VALUES ('$cliente', '$descripcion', $monto, NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Presupuesto creado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
