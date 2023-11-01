

$(document).ready(function () {
    // Llenar el select de fabricantes con datos dinámicamente
    $.ajax({
        type: "GET",
        url: "obtener_fabricantes.php",
        success: function (data) {
            var fabricanteSelect = $("#fabricante");
            fabricanteSelect.empty();
            fabricanteSelect.append($('<option>', {
                value: "",
                text: "Selecciona un fabricante"
            }));
            $.each(data, function (index, value) {
                fabricanteSelect.append($('<option>', {
                    value: value,
                    text: value
                }));
            });
        }
    });

    // Manejar el cambio en la selección del fabricante
    $("#fabricante").on("change", function () {
        var selectedFabricante = $(this).val();
        if (selectedFabricante) {
            // Habilitar el select de serie y cargar las opciones
            $("#serie").prop("disabled", false);
            $.ajax({
                type: "GET",
                url: "obtener_series.php?fabricante=" + selectedFabricante,
                success: function (data) {
                    var serieSelect = $("#serie");
                    serieSelect.empty();
                    serieSelect.append($('<option>', {
                        value: "",
                        text: "Selecciona una serie"
                    }));
                    $.each(data, function (index, value) {
                        serieSelect.append($('<option>', {
                            value: value,
                            text: value
                        }));
                    });
                }
            });
        } else {
            // Deshabilitar y vaciar el select de serie y acabado
            $("#serie").prop("disabled", true);
            $("#acabado").prop("disabled", true);
            $("#serie").empty();
            $("#acabado").empty();
        }
    });

    // Manejar el cambio en la selección de la serie
    $("#serie").on("change", function () {
        var selectedSerie = $(this).val();
        if (selectedSerie) {
            // Habilitar el select de acabado y cargar las opciones
            $("#acabado").prop("disabled", false);
            $.ajax({
                type: "GET",
                url: "obtener_acabado.php?serie=" + selectedSerie,
                success: function (data) {
                    var acabadoSelect = $("#acabado");
                    acabadoSelect.empty();
                    acabadoSelect.append($('<option>', {
                        value: "",
                        text: "Selecciona un acabado"
                    }));
                    $.each(data, function (index, value) {
                        acabadoSelect.append($('<option>', {
                            value: value,
                            text: value
                        }));
                    });
                }
            });
        } else {
            // Deshabilitar y vaciar el select de acabado
            $("#acabado").prop("disabled", true);
            $("#acabado").empty();
       
