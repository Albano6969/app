<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Confirmar Eliminación</title>
</head>
<body>
    
    <h1>Confirmar Eliminación</h1>

    <?php
    // Conexión a la base de datos (reemplaza con tus datos de conexión)
    include("../../config.php");

    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $articuloId = $_GET["id"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Procesa la eliminación del artículo
        
            $sql = "DELETE FROM articulos WHERE id_articulo = $articuloId";
            if ($conn->query($sql) === TRUE) {
                header("Location: modificar_articulos.php?exito=1");
                exit; // Importante para detener la ejecución después de la redirección
            } else {
                echo "Error al eliminar el artículo: " . $conn->error;
            }
        }

        // Consulta SQL para obtener los detalles del artículo
        $sql = "SELECT funcion, descripcion, precio, referencia FROM articulos WHERE id_articulo = $articuloId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p style='margin-left: 50px;'>¿Estás seguro de que deseas eliminar el siguiente artículo?</p>";
            echo "<p style='margin-left: 50px;'>Función: " . $row["funcion"] . "</p>";
            echo "<p style='margin-left: 50px;'>Descripción: " . $row["descripcion"] . "</p>";
            echo "<p style='margin-left: 50px;'>Precio: " . $row["precio"] . "</p>";
            echo "<p style='margin-left: 50px;'>Referencia: " . $row["referencia"] . "</p>";
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

    ?>
    <!-- Div para mostrar el mensaje (inicialmente oculto) -->
    <div id="mensaje" class="popup"></div>

    <script>
        // Función para mostrar el mensaje con el estilo especificado y luego ocultarlo después de unos segundos
        function mostrarMensaje(mensaje, estilo) {
            var mensajeDiv = document.getElementById("mensaje");
            mensajeDiv.textContent = mensaje;
            mensajeDiv.className = "popup " + estilo;
            mensajeDiv.style.display = "block";
            setTimeout(function () {
                mensajeDiv.style.display = "none";
            }, 3000); // El mensaje se ocultará después de 3 segundos (3000 ms)
        }

        // Verificar si el parámetro "exito" está presente en la URL y mostrar un mensaje de éxito
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('exito')) {
            mostrarMensaje("Cambios guardados correctamente", "success");
        }

        // Verificar si el parámetro "error" está presente en la URL y mostrar un mensaje de error
        if (urlParams.has('error')) {
            mostrarMensaje("No se han podido guardar los cambios", "error");
        }
    </script>
</body>
</html>
