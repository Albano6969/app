
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
                        var valorInicial = 0;
                    
                        for (var i = 0; i < response.length; i++) {
                            var producto = response[i];
                            var productosRelacionados = producto.productos_relacionados;
                    
                            var filaPrincipal = "<tr data-id='" + producto.id_articulo + "'>"; // Asigna el ID del producto como data-id
                            filaPrincipal += "<td contenteditable='true' class='cantidad-articulo-principal'>" + valorInicial + "</td>";
                            filaPrincipal += "<td>" + producto.funcion + "</td>";
                            filaPrincipal += "<td>" + producto.descripcion + "</td>";
                            filaPrincipal += "<td>" + producto.referencia + "</td>";
                            filaPrincipal += "<td>" + producto.precio + "</td>";
                            filaPrincipal += "<td class='resultado'>" + 0.00 + "</td>";
                            filaPrincipal += "</tr>";
                            tablaProductos.append(filaPrincipal);
                            console.log(producto.id);
                    
                            for (var j = 0; j < productosRelacionados.length; j++) {
                                var productoRelacionado = productosRelacionados[j];
                                var filaRelacionada = "<tr data-id='" + productoRelacionado.id_relacionado + "'>"; // Asigna el ID del producto relacionado como data-id
                                filaRelacionada += "<td class='fila-articulos-relacionados' contenteditable='false'>" + valorInicial + "</td>";
                                filaRelacionada += "<td></td>";
                                filaRelacionada += "<td>" + productoRelacionado.descripcion + "</td>";
                                filaRelacionada += "<td>" + productoRelacionado.referencia + "</td>";
                                filaRelacionada += "<td>" + productoRelacionado.precio + "</td>";
                                filaRelacionada += "<td class='resultado'>" + 0.00 + "</td>";
                                filaRelacionada += "</tr>";
                                tablaProductos.append(filaRelacionada);
                                console.log(productoRelacionado.id);
                            }
                            
                    
                        }
                        // Agregar eventos para sincronizar las cantidades
                        $(".cantidad-articulo-principal").on("input", actualizarCantidadProductosRelacionados);
                        $(".cantidad-articulo-principal").each(actualizarCantidadProductosRelacionados);

                         // Llama a la función para sincronizar los valores al cargar la página
                        $(".cantidad-articulo-principal").each(function () {
                            actualizarCantidadProductosRelacionados.call(this);
                            $(this).trigger("input");
                        });
                        
                        // Llama a calcularTotales después de agregar las filas
                        calcularTotales();

                        
                        $("#tabla-productos tbody tr td.cantidad-articulo-principal").on("keydown", function (e) {
                            if (e.key === "Enter") {
                                e.preventDefault();
                                var fila = $(this).closest("tr");
                                var siguienteFila = fila.next();
                        
                                // Encuentra la siguiente fila de "artículos" evitando "artículos relacionados"
                                while (siguienteFila.length > 0 && !siguienteFila.find(".cantidad-articulo-principal").length) {
                                    siguienteFila = siguienteFila.next();
                                }
                        
                                if (siguienteFila.length > 0) {
                                    var siguienteCampo = siguienteFila.find("td.cantidad-articulo-principal");
                                    siguienteCampo.attr("contenteditable", "true");
                                    siguienteCampo.focus();
                                }
                            }
                            actualizarCantidadProductosRelacionados();
                        });

                        $("#tabla-productos tbody tr td:first-child").on("input", function () {
                            var fila = $(this).closest("tr");
                            var unidades = parseFloat($(this).text().replace(',', '.'), 10);

                            if (isNaN(unidades)) {
                                unidades = 0.0;
                            }

                            var precioUnitario = parseFloat(fila.find("td:eq(4)").text().replace(',', '.'), 10);

                            var pvpTotal = unidades * precioUnitario;
                            if (isNaN(pvpTotal)) {
                                pvpTotal = 0.0;
                            }
                            fila.find("td:last-child").text(pvpTotal.toFixed(2));

                            actualizarCantidadProductosRelacionados();
                            // Llama a calcularTotales después de editar una fila
                            calcularTotales();
                        });


                        
                        // Función para actualizar automáticamente los campos de cantidad de productos relacionados y recalcular pvp-total
                        function actualizarCantidadProductosRelacionados() {
                            var cantidadArticuloPrincipal = parseFloat($(this).text().replace(',', '.'), 10);

                            if (!isNaN(cantidadArticuloPrincipal)) {
                                var fila = $(this).closest("tr");
                                var dataId = fila.data("id");

                                // Actualizar las unidades solo en los artículos relacionados que tengan el mismo data-id
                                var filasRelacionadas = $("tr[data-id=" + dataId + "]").not(fila);
                                filasRelacionadas.each(function() {
                                    var cantidadProductosRelacionados = $(this).find(".fila-articulos-relacionados");
                                    cantidadProductosRelacionados.text(cantidadArticuloPrincipal);
                                    actualizarPvpTotal($(this)); // Llama a una función para actualizar el pvp-total
                                });
                            }

                            // Llama a calcularTotales después de editar una fila
                            calcularTotales();
                        }

                        // Función para actualizar el pvp-total de una fila
                        function actualizarPvpTotal(fila) {
                            var unidades = parseFloat(fila.find(".fila-articulos-relacionados").text().replace(',', '.'), 10);
                            var precioUnitario = parseFloat(fila.find("td:eq(4)").text().replace(',', '.'), 10);
                            
                            if (!isNaN(unidades) && !isNaN(precioUnitario)) {
                                var pvpTotal = unidades * precioUnitario;
                                fila.find("td:last-child").text(pvpTotal.toFixed(2));
                            }
                        }

                        // Agrega un evento para escuchar los cambios en los campos de cantidad del artículo principal
                        $(".cantidad-articulo-principal").on("input", actualizarCantidadProductosRelacionados);

                        // Llama a la función en todas las filas para sincronizar los valores
                        $(".cantidad-articulo-principal").each(actualizarCantidadProductosRelacionados);


                        $("#tabla-productos tbody tr td:first-child").on("blur", function () {
                            if ($(this).text().trim() === "") {
                                $(this).text("0");
                            }

                            $(this).trigger("input");
                            
                        });

                        $("#tabla-productos tbody tr td:first-child").on("blur", function () {
                            if ($(this).text().trim() === "") {
                                $(this).text("0");
                            }
                            
                        });

                        $("#tabla-productos tbody tr td:first-child").on("input", function () {
                            var fila = $(this).closest("tr");
                            var unidades = parseFloat($(this).text().replace(',', '.'), 10);

                            if (isNaN(unidades)) {
                                unidades = 0.0;
                            }

                            var precioUnitario = parseFloat(fila.find("td:eq(4)").text().replace(',', '.'), 10);

                            $("#tabla-productos tbody tr td:first-child").on("focus", function () {
                                $(this).text("");
                                actualizarCantidadProductosRelacionados();
                            });

                            var pvpTotal = unidades * precioUnitario;
                            if (isNaN(pvpTotal)) {
                                pvpTotal = 0.0;
                            }
                            fila.find("td:last-child").text(pvpTotal.toFixed(2));
                        });
                    }
                });
            }
        }

        

            $("#fabricante").on("change", function () {
                fabricanteSeleccionado = $(this).val();
                cargarProductos();
            });

            $("#serie").on("change", function () {
                serieSeleccionada = $(this).val();
                cargarProductos();
            });

            $("#acabado").on("change", function () {
                acabadoSeleccionado = $(this).val();
                cargarProductos();
            });
        });
    });
