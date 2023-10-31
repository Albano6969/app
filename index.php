<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Crear Presupuesto</title>
</head>
<body>
    <h1>Crear Presupuestos</h1>
    <form action="procesar_presupuesto.php" method="POST">
        <label for="cliente">Cliente:</label>
        <input type="text" name="cliente" required><br>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea><br>
        <label for="monto">Monto:</label>
        <input type="number" name="monto" step="0.01" required><br>
        <label for="articulo">Seleccionar Artículo:</label>
        <select name="articulo">
            <option value="">Selecciona un artículo</option>
            <?php
            // Recupera la lista de artículos desde la base de datos
            $sql = "SELECT id, nombre, precio FROM articulos";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["id"] . '">' . $row["nombre"] . ' - $' . $row["precio"] . '</option>';
                }
            };
            ?>
        </select>
        <input type="submit" value="Guardar Presupuesto">
        <a href="exportar_pdf.php" class="btn-exportar-pdf">Exportar a PDF</a>
    </form>
    
</body>
</html>