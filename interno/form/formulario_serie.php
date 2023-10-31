<!-- Formulario para ingresar datos de Serie -->
<form action="procesar_serie.php" method="POST">
        <h2>Serie</h2>
        <label for="nombre_serie">Nombre de la Serie:</label>
        <input type="text" name="nombre_serie" required>
        <label for="id_fabricante_serie">Fabricante:</label>
            <select name="id_fabricante_serie" required>
                <?php
                include '../config.php';

                // Consulta SQL para obtener la información de la tabla fabricantes
                $sql = "SELECT id_fabricante, nombre_fabricante FROM fabricantes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["id_fabricante"] . '">' . $row["nombre_fabricante"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay fabricantes disponibles</option>';
                }

                // Cierra la conexión a la base de datos
                $conn->close();
                ?>
            </select>
        <input type="submit" value="Guardar Serie">
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
