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