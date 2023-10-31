<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
    <title>Artículos Relacionados</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    <h1>Artículos Relacionados</h1>
    <form action="procesar_articulos_relacionados.php" method="POST">
        <label for="fabricante">Fabricante:</label>
        <select id="fabricante" name="fabricante" required>
            <option value="">Selecciona un fabricante</option>
            <option value="2">bjc</option>
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

        <label for="acabado">Acabado:</label>
        <select id="acabado" name="acabado" required>
            <option value="">Selecciona un acabado</option>
        </select>

        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <input type="submit" value="Guardar Artículo">

    </form>

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
                            // Resetear el selector de acabado
                            $("#acabado").html('<option value="">Selecciona un acabado</option>');
                        }
                    });
                } else {
                    $("#serie").html('<option value="">Selecciona una serie</option>');
                    $("#acabado").html('<option value="">Selecciona un acabado</option>');
                }
            });

            // Cuando se cambia la selección de la serie
            $("#serie").on("change", function() {
                var serieId = $(this).val();
                if (serieId !== "") {
                    // Realizar una solicitud AJAX para obtener los acabados basados en la serie seleccionada
                    $.ajax({
                        url: "obtener_acabados.php", // Reemplaza con la URL de tu script PHP
                        type: "POST",
                        data: { serieId: serieId },
                        success: function(response) {
                            $("#acabado").html(response);
                        }
                    });
                } else {
                    $("#acabado").html('<option value="">Selecciona un acabado</option>');
                }
            });
        });
    </script>
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
</body>
</html>
    
