<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css"> <!-- Agrega tu hoja de estilos CSS -->
    <title>Modificar Artículos</title>
</head>
<body>
   

    <h1>Modificar Artículos</h1>

    <div class="container" id="formulario-container">
    <?php
// Conexión a la base de datos (debes incluir tu archivo de configuración)
include("../../config.php");

$sql = "SELECT a.id_articulo, a.funcion, a.descripcion, a.precio, a.referencia, f.nombre_fabricante, s.nombre_serie AS nombre_serie
        FROM articulos a
        INNER JOIN serie s ON a.id_serie = s.id_serie
        INNER JOIN fabricantes f ON s.id_fabricante = f.id_fabricante";
        

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Función</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Referencia</th>
                <th>Fabricante</th>
                <th>Serie</th>
                <th>Acciones</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id_articulo"] . "</td>
                <td>" . $row["funcion"] . "</td>
                <td>" . $row["descripcion"] . "</td>
                <td>" . $row["precio"] . "</td>
                <td>" . $row["referencia"] . "</td>
                <td>" . $row["nombre_fabricante"] . "</td>
                <td>" . $row["nombre_serie"] . "</td>
                <td>
                    <a href='editar_articulo.php?id=" . $row["id_articulo"] . "'>Editar</a>
                    <a href='confirmar_eliminacion.php?id=" . $row["id_articulo"] . "'>Eliminar</a>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron artículos en la base de datos.";
}

// Cierra la conexión a la base de datos
$conn->close();
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
