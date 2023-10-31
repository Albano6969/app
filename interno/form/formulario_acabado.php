<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Formulario para ingresar datos de Acabado -->
<form action="../procesar_acabado.php" method="POST" target="_top">
        <h2>Acabado</h2>
        <label for="nombre_acabado">Nombre del Acabado:</label>
        <input type="text" name="nombre_acabado" required>
        <label for="fabricante">Fabricante:</label>
        <select id="fabricante" name="fabricante" required>
            <option value="">Selecciona un fabricante</option>
            <?php
            include("../../config.php");
            // Realiza una consulta a la base de datos para obtener los fabricantes
            $sql = "SELECT id_fabricante, nombre_fabricante FROM fabricantes";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["id_fabricante"] . '">' . $row["nombre_fabricante"] . '</option>';
                }
            };
            ?>
        </select>

        <label for="serie">Serie:</label>
        <select id="serie" name="serie" required>
            <option value="">Selecciona una serie</option>
            
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
<script>
        $(document).ready(function() {
            // Cuando se cambia la selección del fabricante
            $("#fabricante").on("change", function() {
                var fabricanteId = $(this).val();
                
                if (fabricanteId !== "") {
                    // Realizar una solicitud AJAX para obtener las series basadas en el fabricante seleccionado
                    $.ajax({
                        url: "obtener_series.php", // Reemplaza con la URL de tu script PHP
                        type: "POST",
                        data: { fabricanteId: fabricanteId },
                        success: function(response) {
                            $("#serie").html(response);
                        }
                    });
                } else {
                    $("#serie").html('<option value="">Selecciona una serie</option>');
                    
                }
            });
        });
    </script>
</body>
</html>