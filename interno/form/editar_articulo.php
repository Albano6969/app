<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Editar Artículo</title>
</head>
<body>
   

    <h1>Editar Artículo</h1>

    <div class="container" id="formulario-container">
        <?php
        include("../../config.php");

        if (isset($_GET['id'])) {
            $articuloId = $_GET['id'];

            // Consulta SQL para obtener los detalles del artículo, incluyendo fabricante, serie y acabado
            $sql = "SELECT a.funcion, a.descripcion, a.precio, a.referencia, f.nombre_fabricante, s.nombre AS nombre_serie, ac.nombre AS nombre_acabado
                    FROM articulos a
                    INNER JOIN fabricantes f ON a.id_fabricante = f.id_fabricante
                    INNER JOIN serie s ON a.id_serie = s.id
                    INNER JOIN acabado ac ON a.id_acabado = ac.id
                    WHERE a.id_articulo = $articuloId";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<form action="procesar_edicion.php" method="POST">
                    <input type="hidden" name="articulo_id" value="' . $articuloId . '">
                    <label for="funcion">Función del Artículo:</label>
                    <input type="text" name="funcion" required value="' . $row["funcion"] . '">
                    <label for="descripcion">Descripción del Artículo:</label>
                    <textarea name="descripcion" required>' . $row["descripcion"] . '</textarea>
                    <label for="precio">Precio del Artículo:</label>
                    <input type="number" name="precio" step="0.01" required value="' . $row["precio"] . '">
                    <label for="referencia">Referencia del Artículo:</label>
                    <input type="text" name="referencia" required value="' . $row["referencia"] . '">
                    <p>Fabricante: ' . $row["nombre_fabricante"] . '</p>
                    <p>Serie: ' . $row["nombre_serie"] . '</p>
                    <p>Acabado: ' . $row["nombre_acabado"] . '</p>
                    <input type="submit" value="Guardar Cambios">
                </form>';
            } else {
                echo "Artículo no encontrado.";
            }
        }
        ?>
    </div>

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
