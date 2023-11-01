<?php
// Conexión a la base de datos
include('config.php');

// Datos generales del presupuesto
$empresa = $_POST['empresa'];
$numeroPresupuesto = $_POST['numero_presupuesto'];
$fecha = $_POST['fecha'];
$realizadoPor = $_POST['realizado_por'];
$clienteEmpresa = $_POST['cliente_empresa'];
$clienteNombre = $_POST['cliente_nombre'];
$clienteDireccion = $_POST['cliente_direccion'];
$clientePoblacion = $_POST['cliente_poblacion'];
$clienteEmail = $_POST['cliente_email'];
$clienteTelefono = $_POST['cliente_telefono'];

// Insertar datos generales en la tabla 'presupuestos'
$sqlPresupuesto = "INSERT INTO presupuestos (empresa, numero_presupuesto, fecha, realizado_por, cliente_empresa, cliente_nombre, cliente_direccion, cliente_poblacion, cliente_email, cliente_telefono)
                  VALUES ('$empresa', '$numeroPresupuesto', '$fecha', '$realizadoPor', '$clienteEmpresa', '$clienteNombre', '$clienteDireccion', '$clientePoblacion', '$clienteEmail', '$clienteTelefono')";

if ($conn->query($sqlPresupuesto) === TRUE) {
    $idPresupuesto = $conn->insert_id; // Obtenemos el ID del nuevo presupuesto

    // Procesar datos de artículos (múltiples artículos)
    $articulos = $_POST['articulos']; // Ajusta el nombre según tu formulario (debe ser un array)
    
    // Iterar a través de los artículos y guardarlos en la tabla 'articulos_presupuestos'
    foreach ($articulos as $articulo) {
        $idArticulo = $articulo['id_articulo'];
        $cantidad = $articulo['cantidad'];
        $precioUnidad = $articulo['precio_unidad'];
        $precioTotal = $articulo['precio_total'];
        $descuento = $articulo['descuento'];

        $sqlArticulos = "INSERT INTO articulos_presupuestos (id_presupuesto, id_articulo, cantidad, precio_unidad, precio_total, descuento)
                         VALUES ('$idPresupuesto', '$idArticulo', '$cantidad', '$precioUnidad', '$precioTotal', '$descuento')";

        if ($conn->query($sqlArticulos) !== TRUE) {
            // Manejo de errores si no se pueden insertar los datos de los artículos
        }
    }

    // Procesamiento exitoso, puedes redirigir o mostrar un mensaje de éxito
    header('Location: index.php?exito=1');
} else {
    // Manejo de errores si no se pueden insertar los datos generales del presupuesto
}

// Cierra la conexión a la base de datos
$conn->close();
?>

