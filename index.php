<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/presupuestos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Crear Presupuesto</title>
</head>
<body>
    <h1>Crear Presupuesto</h1>
    <form action="procesar_presupuesto.php" method="POST">
        <div class="izquierda">
            <h2>Detalles de la Empresa</h2>
            <label for="nombre_empresa">Nombre de la Empresa:</label>
            <input type="text" name="nombre_empresa" required>

            <label for="numero_presupuesto">Número de Presupuesto:</label>
            <input type="text" name="numero_presupuesto" required>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha"  value="<?php echo date('Y-m-d'); ?>" required>

            <label for="realizado_por">Realizado Por:</label>
            <input type="text" name="realizado_por" required>
        </div>

        <div class="derecha">
            <h2>Detalles del Cliente</h2>
            <label for="nombre_cliente">Nombre del Cliente:</label>
            <input type="text" name="nombre_cliente" required>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" required>

            <label for="poblacion">Población:</label>
            <input type="text" name="poblacion" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" required>
        </div>

        <div class="productos">
            <h2>Productos / Servicios</h2>
            <!-- Select para fabricantes -->
            <label for="fabricante">Fabricante:</label>
            <select name="fabricante" id="fabricante">
                <option value="">Todos los fabricantes</option>
            </select>

            <!-- Select para series -->
            <label for="serie">Serie:</label>
            <select name="serie" id="serie">
                <option value="">Todas las series</option>
            </select>

            <!-- Select para acabados -->
            <label for="acabado">Acabado:</label>
            <select name="acabado" id="acabado">
                <option value="">Todos los acabados</option>
            </select>

            <table>
                <tr>
                    <th>Unidades</th>
                    <th>Función</th>
                    <th>Referencia</th>
                    <th>Descripción</th>
                    <th>Precio Unidad</th>
                    <th>PVP Total</th>
                </tr>
                <tr>
                    <td><input type="number" name="unidades[]"></td>
                    <td><input type="text" name="funcion[]"></td>
                    <td><input type="text" name="referencia[]"></td>
                    <td><input type="text" name="descripcion[]"></td>
                    <td><input type="number" name="precio_unidad[]"></td>
                    <td><input type="number" name="pvp_total[]" readonly></td>
                </tr>
                <!-- Puedes agregar más filas de productos con JavaScript -->
            </table>
        </div>

        <div class="totales">
            <label for="descuento">Descuento (%):</label>
            <input type="number" name="descuento" id="descuento">

            <label for="total_pvr">Total PVR:</label>
            <input type="text" name="total_pvr" id="total_pvr" readonly>

            <label for="precio_neto_total">Precio Neto Total:</label>
            <input type="text" name="precio_neto_total" id="precio_neto_total" readonly>
        </div>

        <input type="submit" value="Crear Presupuesto">
        <div id="boton-generar-pdf" class="cuadrado-izquierda">
    </form>

    <!-- Script para cargar dinámicamente los datos de fabricantes, series y acabados -->
    <script>
    $(document).ready(function () {
    // Función para cargar los fabricantes
    function cargarFabricantes() {
        $.ajax({
            url: "obtener_fabricantes.php",
            type: "GET",
            success: function (response) {
                var fabricanteSelect = $("#fabricante");
                fabricanteSelect.empty();

                fabricanteSelect.append('<option value="">Todos los fabricantes</option>');

                for (var i = 0; i < response.length; i++) {
                    fabricanteSelect.append('<option value="' + response[i].id_fabricante + '">' + response[i].nombre_fabricante + '</option>');
                }
            }
        });
    }

    cargarFabricantes();
});

    // Cuando se cambia la selección del fabricante
    $("#fabricante").on("change", function() {
        var fabricanteId = $(this).val();
        console.log(fabricanteId); // Agrega esta línea para depurar
        if (fabricanteId !== "") {
            // Realizar una solicitud AJAX para obtener las series basadas en el fabricante seleccionado
            $.ajax({
                url: "obtener_series.php", // Asegúrate de que la URL sea la correcta
                type: "POST",
                data: { fabricanteId: fabricanteId },
                success: function(response) {
                    console.log(response); // Agrega esta línea para depurar
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
            $.ajax({
                url: "obtener_acabado.php", // Asegúrate de que la URL sea la correcta
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
</script>


<!-- Script para calcular los totales -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener los elementos de la tabla de artículos
        var tablaArticulos = document.getElementById("tabla-articulos");
        var tbodyArticulos = tablaArticulos.querySelector("tbody");
        var descuentoInput = document.getElementById("descuento");
        var totalPvrInput = document.getElementById("total-pvr");
        var precioNetoTotalInput = document.getElementById("precio-neto-total");

        // Función para calcular los totales
        function calcularTotales() {
            var filas = tbodyArticulos.getElementsByTagName("tr");
            var totalPvr = 0;

            for (var i = 0; i < filas.length; i++) {
                var fila = filas[i];
                var unidades = parseFloat(fila.querySelector(".unidades").textContent);
                var precioUnidad = parseFloat(fila.querySelector(".precio-unidad").textContent);
                var pvpTotal = unidades * precioUnidad;
                fila.querySelector(".pvp-total").textContent = pvpTotal.toFixed(2);
                totalPvr += pvpTotal;
            }

            totalPvrInput.value = totalPvr.toFixed(2);
            var descuento = parseFloat(descuentoInput.value) || 0;
            var precioNetoTotal = totalPvr * (1 - descuento / 100);
            precioNetoTotalInput.value = precioNetoTotal.toFixed(2);
        }

        // Calcular totales al cargar la página
        calcularTotales();

        // Recalcular totales al cambiar el descuento
        descuentoInput.addEventListener("input", calcularTotales);
    });
</script>

<!-- Script para generar un PDF -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var botonGenerarPDF = document.getElementById("boton-generar-pdf");
        botonGenerarPDF.addEventListener("click", function () {
            // Aquí puedes agregar el código para generar un PDF con los datos de la hoja de presupuestos
            // Puedes utilizar una biblioteca como tcpdf o jsPDF para generar el PDF.
            // La información del presupuesto y los artículos se encuentra en el DOM y puedes obtenerla
            // mediante document.getElementById o querySelector.

            // Una vez que generes el PDF, puedes abrirlo en una nueva ventana o descargarlo, según tu preferencia.
        });
    });
</script>
</body>
</html>