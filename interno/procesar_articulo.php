<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera los datos del formulario
    $funcion_articulo = $_POST['funcion_articulo'];
    $descripcion_articulo = $_POST['descripcion_articulo'];
    $precio_articulo = $_POST['precio_articulo'];
    $referencia_articulo = $_POST['referencia_articulo'];
    $id_serie_articulo = $_POST['serie'];

    // Realiza la inserción en la tabla 'articulos' (reemplaza con tu consulta SQL)
    $sql = "INSERT INTO articulos (funcion, descripcion, precio, referencia, id_serie) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdsi', $funcion_articulo, $descripcion_articulo, $precio_articulo, $referencia_articulo, $id_serie_articulo);

    if ($stmt->execute()) {
        echo "Artículo guardado correctamente.";
    } else {
        echo "Error al guardar el artículo: " . $stmt->error;
    }

    $stmt->close();
}

// Cierra la conexión a la base de datos
$conn->close();
header("Location: creacion.php?exito=1");
exit();
?>

