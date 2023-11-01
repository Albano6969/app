// Escuchar el evento DOMContentLoaded para asegurarse de que el documento está completamente cargado
document.addEventListener("DOMContentLoaded", function () {
    $(document).ready(function () {
        // Variables para almacenar los valores seleccionados
        var fabricanteSeleccionado = "";
        var serieSeleccionada = "";
        var acabadoSeleccionado = "";

        // Función para cargar productos basados en los criterios seleccionados
        function cargarProductos() {
            // Verificar si los tres criterios están seleccionados
            if (fabricanteSeleccionado !== "" && serieSeleccionada !== "" && acabadoSeleccionado !== "") {
                // Realizar una solicitud AJAX para obtener los productos basados en los criterios
                $.ajax({
                    url: "obtener_productos.php", // Reemplaza con la URL de tu script PHP
                    type: "POST",
                    data: {
                        fabricante: fabricanteSeleccionado,
                        serie: serieSeleccionada,
                        acabado: acabadoSeleccionado
                    },
                    success: function (response) {
                        // Obtener la tabla de productos
                        var tablaProductos = $("#tabla-productos tbody");
                        tablaProductos.empty(); // Limpiar la tabla
                        var valorInicial = 0; // Valor inicial para la primera fila
                        var valorInicialTotales = 0.0; // Valor inicial para la primera fila

                        // Variable para controlar si es la primera fila
                        var esPrimeraFila = true;

                        // Iterar a través de los productos y agregar filas a la tabla
                        for (var i = 0; i < response.length; i++) {
                            var producto = response[i];
                            var fila = "<tr>";
                            fila += "<td contenteditable='true'>" + valorInicial + "</td>";
                            fila += "<td>" + producto.funcion + "</td>";
                            fila += "<td>" + producto.referencia + "</td>";
                            fila += "<td>" + producto.descripcion + "</td>";
                            fila += "<td>" + producto.precio + "</td>";
                            fila += "<td class='resultado'>" + valorInicialTotales + "</td>";
                            fila += "</tr>";
                            tablaProductos.append(fila);
                        }

                        // Evitar el salto de línea al presionar "Enter" en el campo de unidades
                        $("#tabla-productos tbody tr td:first-child").on("keydown", function (e) {
                            if (e.key === "Enter") {
                                e.preventDefault();
                                var fila = $(this).closest("tr");
                                var siguienteFila = fila.next(); // Obtener la fila siguiente

                                if (siguienteFila.length > 0) {
                                    var siguienteCampo = siguienteFila.find("td:first-child");
                                    siguienteCampo.attr("contenteditable", "true"); // Hacer editable el campo de la siguiente fila
                                    siguienteCampo.focus(); // Establecer el foco en el campo editable
                                }

                                // Permitir solo números y la tecla "Enter"
                                if (!((e.key >= "0" && e.key <= "9") || e.key === "Enter" || e.key === "Backspace" || e.key === "Delete")) {
                                    e.preventDefault();
                                }
                            }
                        });

                        // Manejar el evento input en la primera fila (user-editable) para permitir solo números enteros y calcular PVP Total
                        $("#tabla-productos tbody tr td:first-child").on("input", function () {
                            // Obtener la fila actual y el valor ingresado
                            var fila = $(this).closest("tr");
                            var unidades = parseFloat($(this).text().replace(',', '.'), 10); // Asegurarse de que se maneje como número de punto flotante

                            // Verificar si el valor de unidades es un número válido
                            if (isNaN(unidades)) {
                                unidades = 0.0; // Cambiar NaN a 0.0
                            }

                            // Obtener el precio unitario de la misma fila
                            var precioUnitario = parseFloat(fila.find("td:eq(4)").text().replace(',', '.'), 10); // Asegurarse de que se maneje como número de punto flotante

                            // Calcular el PVP Total y mostrarlo en la última columna
                            var pvpTotal = unidades * precioUnitario;
                            if (isNaN(pvpTotal)) {
                                pvpTotal = 0.0; // Cambiar NaN a 0.0
                            }
                            fila.find("td:last-child").text(pvpTotal.toFixed(2));
                        });

                        // Manejar el evento blur para la primera fila (user-editable) y asegurarse de que no quede vacío
                        $("#tabla-productos tbody tr td:first-child").on("blur", function () {
                            // Asegurarse de que el campo de unidades tenga un valor de 0
                            if ($(this).text().trim() === "") {
                                $(this).text("0");
                            }

                            // Disparar el evento input para recalcular PVP Total
                            $(this).trigger("input");
                        });

                        // Manejar el evento blur para la primera fila (user-editable) y asegurarse de que no quede vacío
                        $("#tabla-productos tbody tr td:first-child").on("blur", function () {
                            // Asegurarse de que el campo de unidades tenga un valor de 0
                            if ($(this).text().trim() === "") {
                                $(this).text("0");
                            }
                        });

                        // Manejar el evento input en la primera fila (user-editable) para permitir solo números enteros y calcular PVP Total
                        $("#tabla-productos tbody tr td:first-child").on("input", function () {
                            // Obtener la fila actual y el valor ingresado
                            var fila = $(this).closest("tr");
                            var unidades = parseFloat($(this).text().replace(',', '.'), 10); // Asegurarse de que se maneje como número de punto flotante

                            // Verificar si el valor de unidades es un número válido
                            if (isNaN(unidades)) {
                                unidades = 0.0; // Cambiar NaN a 0.0
                            }

                            // Obtener el precio unitario de la misma fila
                            var precioUnitario = parseFloat(fila.find("td:eq(4)").text().replace(',', '.'), 10); // Asegurarse de que se maneje como número de punto flotante

                            // Manejar el evento de enfoque (focus) en la primera fila para borrar el valor actual
                            $("#tabla-productos tbody tr td:first-child").on("focus", function () {
                                $(this).text(""); // Borra el contenido cuando se coloca el cursor en el campo
                            });

                            // Calcular el PVP Total y mostrarlo en la última columna
                            var pvpTotal = unidades * precioUnitario;
                            if (isNaN(pvpTotal)) {
                                pvpTotal = 0.0; // Cambiar NaN a 0.0
                            }
                            fila.find("td:last-child").text(pvpTotal.toFixed(2));
                        });
                    }
                });
            }
        }

        // Manejar cambios en la selección del fabricante
        $("#fabricante").on("change", function () {
            // Actualizar fabricanteSeleccionado con el valor del ID seleccionado
            fabricanteSeleccionado = $(this).val();
            cargarProductos();
        });

        // Manejar cambios en la selección de la serie
        $("#serie").on("change", function () {
            // Actualizar serieSeleccionada con el valor del ID seleccionado
            serieSeleccionada = $(this).val();
            cargarProductos();
        });

        // Manejar cambios en la selección del acabado
        $("#acabado").on("change", function () {
            // Actualizar acabadoSeleccionado con el valor del ID seleccionado
            acabadoSeleccionado = $(this).val();
            cargarProductos();
        });
    });
});
