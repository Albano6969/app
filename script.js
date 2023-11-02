
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
        if (fabricanteId !== "") {
            // Realizar una solicitud AJAX para obtener las series basadas en el fabricante seleccionado
            $.ajax({
                url: "obtener_series.php", // Asegúrate de que la URL sea la correcta
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