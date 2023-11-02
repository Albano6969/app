
document.addEventListener("DOMContentLoaded", function () {
    $(document).ready(function () {
        var fabricanteSeleccionado = "";
        var serieSeleccionada = "";
        var acabadoSeleccionado = "";

        function cargarProductos() {
            

            if (fabricanteSeleccionado !== "" && serieSeleccionada !== "" && acabadoSeleccionado !== "") {
                
                $.ajax({
                    url: "obtener_productos.php",
                    type: "POST",
                    data: {
                        fabricante: fabricanteSeleccionado,
                        serie: serieSeleccionada,
                        acabado: acabadoSeleccionado
                    },
                    success: function (response) {
                        

                        var tablaProductos = $("#tabla-productos tbody");
                        tablaProductos.empty();
                        var valorInicial = 0;
                        var valorInicialTotales = 0.0;

                        for (var i = 0; i < response.length; i++) {
                            var producto = response[i];
                            var productosRelacionados = producto.productos_relacionados;

                            var filaPrincipal = "<tr>";
                            filaPrincipal += "<td contenteditable='true'>" + valorInicial + "</td>";
                            filaPrincipal += "<td>" + producto.funcion + "</td>";
                            filaPrincipal += "<td>" + producto.descripcion + "</td>";
                            filaPrincipal += "<td>" + producto.referencia + "</td>";
                            filaPrincipal += "<td>" + producto.precio + "</td>";
                            filaPrincipal += "<td class='resultado'>" + valorInicialTotales + "</td>";
                            filaPrincipal += "</tr>";
                            tablaProductos.append(filaPrincipal);

                            for (var j = 0; j < productosRelacionados.length; j++) {
                                var productoRelacionado = productosRelacionados[j];
                                var filaRelacionada = "<tr>";
                                filaRelacionada += "<td contenteditable='true'>" + valorInicial + "</td>";
                                filaRelacionada += "<td></td>";
                                filaRelacionada += "<td>" + productoRelacionado.descripcion + "</td>";
                                filaRelacionada += "<td>" + productoRelacionado.referencia + "</td>";
                                filaRelacionada += "<td>" + productoRelacionado.precio + "</td>";
                                filaRelacionada += "<td class='resultado'>" + valorInicialTotales + "</td>";
                                filaRelacionada += "</tr>";
                                tablaProductos.append(filaRelacionada);
                            }
                        }

                        // Llama a calcularTotales después de agregar las filas
                        calcularTotales();

                        $("#tabla-productos tbody tr td:first-child").on("keydown", function (e) {
                            if (e.key === "Enter") {
                                e.preventDefault();
                                var fila = $(this).closest("tr");
                                var siguienteFila = fila.next();

                                if (siguienteFila.length > 0) {
                                    var siguienteCampo = siguienteFila.find("td:first-child");
                                    siguienteCampo.attr("contenteditable", "true");
                                    siguienteCampo.focus();
                                }

                                if (!((e.key >= "0" && e.key <= "9") || e.key === "Enter" || e.key === "Backspace" || e.key === "Delete")) {
                                    e.preventDefault();
                                }
                            }
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

                            // Llama a calcularTotales después de editar una fila
                            calcularTotales();
                        });

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
