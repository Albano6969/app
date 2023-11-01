<?php
// Conexión a la base de datos (incluir tu archivo config.php)
include("config.php");

if (isset($_POST["serieId"])) {
    $serieId = $_POST["serieId"];
    
    // Consulta SQL para obtener los acabados basados en la serie seleccionada
    $sql = "SELECT id_acabado, nombre FROM acabado WHERE id_serie = $serieId";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $options = '<option value="">Selecciona un acabado</option>';
        while ($row = $result->fetch_assoc()) {
            $options .= '<option value="' . $row["id_acabado"] . '">' . $row["nombre"] . '</option>';
        }
        echo $options;
    } else {
        echo '<option value="">No se encontraron acabados</option>';
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
