<?php
include '../config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera los datos del formulario
    $nombre_fabricante = $_POST['nombre_fabricante'];

    // Realiza la inserción en la tabla 'fabricantes' (reemplaza con tu consulta SQL)
    $sql = "INSERT INTO fabricantes (nombre_fabricante) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $nombre_fabricante);

    if ($stmt->execute()) {
        header("Location: creacion.php?exito=1");
        exit();
    } else {
        header("Location: creacion.php?error=1");
        exit();
    }

    $stmt->close();
}

// Cierra la conexión a la base de datos
$conn->close();


?>



