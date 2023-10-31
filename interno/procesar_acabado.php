<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera los datos del formulario
    $nombre_acabado = $_POST['nombre_acabado'];
    $id_serie_acabado = $_POST['serie'];

    // Realiza la inserción en la tabla 'acabado' (reemplaza con tu consulta SQL)
    $sql = "INSERT INTO acabado (nombre, id_serie) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $nombre_acabado, $id_serie_acabado);

    if ($stmt->execute()) {
        echo "Acabado guardado correctamente.";
    } else {
        echo "Error al guardar el acabado: " . $stmt->error;
    }

    $stmt->close();
}

// Cierra la conexión a la base de datos
$conn->close();
header("Location: creacion.php?exito=1");
exit();
?>
