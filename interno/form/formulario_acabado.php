<!-- Formulario para ingresar datos de Acabado -->
<form action="procesar_acabado.php" method="POST">
        <h2>Acabado</h2>
        <label for="nombre_acabado">Nombre del Acabado:</label>
        <input type="text" name="nombre_acabado" required>
        <label for="id_serie_acabado">Serie:</label>
        <select name="id_serie_acabado" required>
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
        <input type="submit" value="Guardar Acabado">
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
