function calcularTotales() {
    var filas = $("#tabla-productos tbody tr");
    var totalPvr = 0;
    var precioNetoTotal = 0;

    filas.each(function () {
        var unidades = parseFloat($(this).find("td:eq(0)").text().replace(',', '.'), 10);
        var precioUnitario = parseFloat($(this).find("td:eq(4)").text().replace(',', '.'), 10);

        if (!isNaN(unidades) && !isNaN(precioUnitario)) {
            var pvpTotal = unidades * precioUnitario;
            totalPvr += pvpTotal;
        }
    });

    // Actualizar el campo total-pvr
    $("#total_pvr").val(totalPvr.toFixed(2));

    // Obtener el descuento (asegúrate de que el campo descuento exista y sea válido)
    var descuento = parseFloat($("#descuento").val()) || 0;

    // Calcular el precio neto total con descuento
    precioNetoTotal = totalPvr * (1 - descuento / 100);

    // Actualizar el campo precio-neto-total
    $("#precio_neto_total").val(precioNetoTotal.toFixed(2));
}

// Agregar controlador de eventos al campo de descuento
$("#descuento").on("input", function () {
    calcularTotales();
});
