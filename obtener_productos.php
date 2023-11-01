<?php
include("config.php");

if (isset($_POST["fabricante"]) && isset($_POST["serie"]) && isset($_POST["acabado"])) {
    $serieId = $_POST["serie"];

    $sql = "SELECT funcion, descripcion, precio, referencia
            FROM articulos
            WHERE id_serie = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serieId);
    $stmt->execute();

    $result = $stmt->get_result();

    $productos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }

    header("Content-Type: application/json");
    echo json_encode($productos);
} else {
    echo "No se proporcionaron criterios de búsqueda.";
}

$conn->close();
?>
