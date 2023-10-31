<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Confirmar Eliminación</title>
</head>
<body>
    <?php
        include 'form/nav.php';
    ?>
    <h1>Confirmar Eliminación</h1>

    <?php
    // Conexión a la base de datos (reemplaza con tus datos de conexión)
    include("config.php");

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $articuloId = $_GET["id"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Procesa la eliminación del artículo (debes completar esta parte)
            
            $sql = "DELETE FROM articulos WHERE id_articulo = $articuloId";
            if ($conn->query($sql) === TRUE) {
                header("Location: modificar_articulos.php?exito=1");
            } else {
                echo "Error al eliminar el artículo: " . $conn->error;
            }
        }

        // Consulta SQL para obtener los detalles del artículo
        $sql = "SELECT funcion, descripcion, precio, referencia FROM articulos WHERE id_articulo = $articuloId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p>¿Estás seguro de que deseas eliminar el siguiente artículo?</p>";
            echo "<p>Función: " . $row["funcion"] . "</p>";
            echo "<p>Descripción: " . $row["descripcion"] . "</p>";
            echo "<p>Precio: " . $row["precio"] . "</p>";
            echo "<p>Referencia: " . $row["referencia"] . "</p>";
            echo '<form action="" method="POST">
                    <input type="submit" value="Eliminar">
                  </form>';
        } else {
            echo "Artículo no encontrado.";
        }
    } else {
        echo "ID de artículo no válido.";
    }

    // Cierra la conexión a la base de datos
    $conn->close();