<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Modificar Artículos</title>
</head>
<body>
    <h1>Modificar Artículos</h1>

    <form method="GET">
        <label for="filtro-fabricante">Filtrar por Fabricante:</label>
        <select name="filtro-fabricante" id="filtro-fabricante">
            <option value="">Todos los fabricantes</option>
            <?php
            // Aquí generas las opciones para seleccionar un fabricante
            include("../../config.php");
            $fabricantesSql = "SELECT nombre_fabricante FROM fabricantes";
            $fabricantesResult = $conn->query($fabricantesSql);
            while ($row = $fabricantesResult->fetch_assoc()) {
                echo '<option value="' . $row["nombre_fabricante"] . '">' . $row["nombre_fabricante"] . '</option>';
            }
            ?>
        </select>

        <label for="filtro-serie">Filtrar por Serie:</label>
        <select name="filtro-serie" id="filtro-serie">
            <option value="">Todas las series</option>
            <?php
            // Aquí generas las opciones para seleccionar una serie
            $seriesSql = "SELECT nombre_serie FROM serie";
            $seriesResult = $conn->query($seriesSql);
            while ($row = $seriesResult->fetch_assoc()) {
                echo '<option value="' . $row["nombre_serie"] . '">' . $row["nombre_serie"] . '</option>';
            }
            ?>
        </select>

        <input type="submit" value="Buscar">
    </form>

    <div class="container" id="formulario-container">
        <?php
        // Conexión a la base de datos (debes incluir tu archivo de configuración)
        include("../../config.php");

        // Obtener valores de los filtros
        $fabricanteFiltro = isset($_GET['filtro-fabricante']) ? $_GET['filtro-fabricante'] : '';
        $serieFiltro = isset($_GET['filtro-serie']) ? $_GET['filtro-serie'] : '';

        // Consulta SQL inicial
        $sql = "SELECT a.id_articulo, a.funcion, a.descripcion, a.precio, a.referencia, f.nombre_fabricante, s.nombre_serie AS nombre_serie
        FROM articulos a
        INNER JOIN serie s ON a.id_serie = s.id_serie
        INNER JOIN fabricantes f ON s.id_fabricante = f.id_fabricante";

        // Aplicar filtros si se han seleccionado
        if (!empty($fabricanteFiltro) && !empty($serieFiltro)) {
        $sql .= " WHERE f.nombre_fabricante = '$fabricanteFiltro' AND s.nombre_serie = '$serieFiltro'";
        } elseif (!empty($fabricanteFiltro)) {
        $sql .= " WHERE f.nombre_fabricante = '$fabricanteFiltro'";
        } elseif (!empty($serieFiltro)) {
        $sql .= " WHERE s.nombre_serie = '$serieFiltro'";
        }

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
    // Función para mostrar el mensaje de éxito y luego ocultarlo después de unos segundos
    function mostrarMensajeExito() {
        var mensajeExito = document.getElementById("mensaje");
        mensajeExito.style.display = "block";
        setTimeout(function () {
            mensajeExito.style.display = "none";
        }, 3000); // El mensaje se ocultará después de 3 segundos (3000 ms)
    }

    // Verificar si la URL tiene el parámetro "exito" y mostrar el mensaje de éxito si es así
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('exito')) {
        mostrarMensajeExito();
    } else {
        var mensajeExito = document.getElementById("mensaje");
        mensajeExito.style.display = "none"; // Ocultar el mensaje si no hay éxito
    }
</script>
</body>
</html>