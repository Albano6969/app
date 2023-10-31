<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $fabricante = $_POST["fabricante"];
    $serie = $_POST["serie"];
    $acabado = $_POST["acabado"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];

    // Realizar una inserción en la tabla de artículos relacionados
    $sql = "INSERT INTO articulo_relacionado (id_articulo, descripcion, precio, id_acabado) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $serie, $descripcion, $precio, $acabado);

    if ($stmt->execute()) {
        // Inserción exitosa, redirigir de vuelta al formulario con un parámetro de éxito
        header("Location: formulario_articulos_relacionados.php?exito=true");
        exit;
    } else {
        // Error en la inserción, redirigir de vuelta al formulario con un parámetro de error
        header("Location: formulario_articulos_relacionados.php?error=true");
        exit;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

header("Location: creacion.php?exito=1");
exit();
?>


