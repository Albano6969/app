<!-- Formulario para ingresar datos de Articulos -->
<form action="procesar_articulo.php" method="POST">
        <h2>Artículo</h2>
        <label for="funcion_articulo">Función del Artículo:</label>
        <input type="text" name="funcion_articulo" required>
        <label for="descripcion_articulo">Descripción del Artículo:</label>
        <textarea name="descripcion_articulo" required></textarea>
        <label for="precio_articulo">Precio del Artículo:</label>
        <input type="number" name="precio_articulo" step="0.01" required>
        <label for="referencia_articulo">Referencia del Artículo:</label>
        <input type="text" name="referencia_articulo" required>
        <label for="id_serie_articulo">Serie:</label>
            <select name="id_serie_articulo" required>
                <?php
                include '../config.php';

                // Consulta SQL para obtener la información de la tabla serie
                $sql = "SELECT id_serie, nombre_serie FROM serie";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["id_serie"] . '">' . $row["nombre_serie"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay series disponibles</option>';
                }

                // Cierra la conexión a la base de datos
                $conn->close();
                ?>
            </select>
        <input type="submit" value="Guardar Artículo">
    </form>

    <script>
    // Función para mostrar el mensaje de éxito y luego ocultarlo después de unos segundos
    function mostrarMensajeExito() {
        var mensajeExito = document.getElementById("mensaje-exito");
        mensajeExito.style.display = "block";
        setTimeout(function () {
            mensajeExito.style.display = "none";
        }, 3000); // El mensaje se ocultará después de 3 segundos (3000 ms)
    }

    // Verificar si la URL tiene el parámetro "exito" y mostrar el mensaje de éxito si es así
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('exito')) {
        mostrarMensajeExito();
    }
</script>
