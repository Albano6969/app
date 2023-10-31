<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/style.css">
<!-- Formulario para ingresar datos de Fabricante -->
<form action="../procesar_fabricante.php" method="POST" target="_top">
    <h2>Fabricante</h2>
    <label for="nombre_fabricante">Nombre del Fabricante:</label>
    <input type="text" name="nombre_fabricante" required>

    <input type="submit" value="Guardar Fabricante">
</form>

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

    // Verificar si la URL tiene el parámetro "exito" y mostrar el mensaje de éxito si es así
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('exito')) {
        mostrarMensaje("El fabricante se ha creado correctamente", "success");
    }
    
    // Verificar si el parámetro "error" está presente en la URL y mostrar un mensaje de error
    if (urlParams.has('error')) {
        mostrarMensaje("No se ha podido ingresar los datos", "error");
    }
</script>
</body>
</html>