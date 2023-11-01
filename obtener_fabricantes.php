<?php
// Conexión a la base de datos (reemplaza con tus datos de conexión)
include("config.php");

// Consulta SQL para obtener los fabricantes
$query = "SELECT id_fabricante, nombre_fabricante FROM fabricantes"; // Incluimos id_fabricante
$result = $conn->query($query);

$fabricantes = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Agregamos un array asociativo con id_fabricante y nombre_fabricante
        $fabricante = array(
            "id_fabricante" => $row["id_fabricante"],
            "nombre_fabricante" => $row["nombre_fabricante"]
        );
        $fabricantes[] = $fabricante;
    }
}

// Devuelve los fabricantes como JSON
header("Content-Type: application/json");
echo json_encode($fabricantes);

// Cierra la conexión a la base de datos
$conn->close();
?>
