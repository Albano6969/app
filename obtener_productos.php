<?php
include("config.php");

if (isset($_POST["fabricante"]) && isset($_POST["serie"]) && isset($_POST["acabado"])) {
    $serieId = $_POST["serie"];

    $sql = "SELECT id_articulo,funcion, descripcion, precio, referencia
            FROM articulos
            WHERE id_serie = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $serieId);
    $stmt->execute();

    $result = $stmt->get_result();

    $productos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $producto = $row;
           

            // Consulta para obtener los productos relacionados
            $sql_relacionados = "SELECT ar.descripcion, ar.precio, ar.referencia, ar.id_articulo AS id_relacionado
            FROM articulo_relacionado ar
            INNER JOIN articulos a ON ar.id_articulo = a.id_articulo
            WHERE a.id_articulo = ? AND ar.id_acabado = ?";

            $stmt_relacionados = $conn->prepare($sql_relacionados);
            $stmt_relacionados->bind_param("ss", $producto['id_articulo'], $_POST["acabado"]);
            $stmt_relacionados->execute();

            $result_relacionados = $stmt_relacionados->get_result();

            $producto['productos_relacionados'] = array();

            if ($result_relacionados->num_rows > 0) {
                while ($row_relacionado = $result_relacionados->fetch_assoc()) {
                    $producto['productos_relacionados'][] = $row_relacionado;
                }
            }

            $productos[] = $producto;
        }
    }

    header("Content-Type: application/json");
    echo json_encode($productos);
} else {
    echo "No se proporcionaron criterios de búsqueda.";
}

$conn->close();
?>

