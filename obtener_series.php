<?php

// Conexión a la base de datos (incluir tu archivo config.php)
include("config.php");

if (isset($_POST["fabricanteId"])) {
    $fabricanteId = $_POST["fabricanteId"];
    
    // Consulta SQL para obtener las series basadas en el fabricante seleccionado
    $sql = "SELECT id_serie, nombre_serie FROM serie WHERE id_fabricante = $fabricanteId";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $options = '<option value="">Selecciona una serie</option>';
        while ($row = $result->fetch_assoc()) {
            $options .= '<option value="' . $row["id_serie"] . '">' . $row["nombre_serie"] . '</option>';
        }
        echo $options;
    } else {
        echo '<option value="">No se encontraron series</option>';
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
