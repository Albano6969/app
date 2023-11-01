
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
                            // Iterar a través de los productos y agregar filas a la tabla
                            for (var i = 0; i < response.length; i++) {
                                var producto = response[i];
                                var fila = "<tr>";
                                fila += "<td contenteditable='true'>" + (i === 0 ? valorInicial : "") +  "</td>";
                                fila += "<td>" + producto.funcion + "</td>";
                                fila += "<td>" + producto.referencia + "</td>";
                                fila += "<td>" + producto.descripcion + "</td>";
                                fila += "<td>" + producto.precio_unidad + "</td>";
                                fila += "<td class='resultado'>" + (i === 0 ? valorInicialTotales.toFixed(2) : "") + "</td>";
                                fila += "</tr>";
                                tablaProductos.append(fila);
                            }
                            
                            // Manejar cambios en la primera fila (user-editable) para permitir solo números enteros
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
                                }

                                // Permitir solo números y la tecla "Enter"
                                if (!((e.key >= "0" && e.key <= "9") || e.key === "Enter" || e.key === "Backspace" || e.key === "Delete")) {
                                    e.preventDefault();
                                }
                            });

                            // Manejar el evento input en la primera fila (user-editable) para permitir solo números enteros y calcular PVP Total
                                $("#tabla-productos tbody tr td:first-child").on("input", function () {
                                    // Obtener la fila actual y el valor ingresado
                                    var fila = $(this).closest("tr");
                                    var unidades = parseInt($(this).text(), 10);
                                    
                                    // Verificar si el valor de unidades es un número válido
                                    if (!isNaN(unidades)) {
                                        // Obtener el precio unitario de la misma fila
                                        var precioUnitario = parseFloat(fila.find("td:eq(4)").text());
                                        
                                        // Calcular el PVP Total y mostrarlo en la última columna
                                        var pvpTotal = unidades * precioUnitario;
                                        if (isNaN(pvpTotal)) {
                                            pvpTotal = 0.0; // Establecer el valor en 0 si el resultado es NaN
                                        }
                                        fila.find("td:last-child").text(pvpTotal.toFixed(2));
                                    } else {
                                        fila.find("td:last-child").text(0); // Mostrar 0 si el valor de unidades no es un número válido
                                    }
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

