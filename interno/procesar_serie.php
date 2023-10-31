<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera los datos del formulario
    $nombre_serie = $_POST['nombre_serie'];
    $id_fabricante_serie = $_POST['id_fabricante_serie'];

    // Realiza la inserción en la tabla 'serie' (reemplaza con tu consulta SQL)
    $sql = "INSERT INTO serie (nombre_serie, id_fabricante) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $nombre_serie, $id_fabricante_serie);

    if ($stmt->execute()) {
        echo "Serie guardada correctamente.";
    } else {
        echo "Error al guardar la serie: " . $stmt->error;
    }

    $stmt->close();
}

// Cierra la conexión a la base de datos
$conn->close();

header("Location: creacion.php?exito=1");
exit();
?>




