<?php
include("config.php");

if (isset($_POST["fabricante"]) && isset($_POST["serie"]) && isset($_POST["acabado"])) {
    $fabricanteId = $_POST["fabricante"];
    $serieId = $_POST["serie"];
    $acabadoId = $_POST["acabado"];

    $sql = "SELECT a.unidades, a.funcion, a.referencia, a.descripcion, a.precio_unidad, a.pvp_total
            FROM articulos AS a
            INNER JOIN articulos_relacionados AS ar ON a.id_articulo = ar.id_articulo
            INNER JOIN series AS s ON a.id_serie = s.id_serie
            WHERE s.id_fabricante = ? AND s.id_serie = ? AND ar.id_acabado = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fabricanteId, $serieId, $acabadoId);
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