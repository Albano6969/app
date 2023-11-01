<?php
include("../../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $articuloId = $_POST["articulo_id"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];

    // Consulta SQL para actualizar la descripción y el precio del artículo
    $sql = "UPDATE articulos SET descripcion = ?, precio = ? WHERE id_articulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $descripcion, $precio, $articuloId);

    if ($stmt->execute()) {
        header("Location: modificar_articulos.php?exito=1");
    } else {
        header("Location: modificar_articulos.php?error=1");
    }
}

$conn->close();

?>
