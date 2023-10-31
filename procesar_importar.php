<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $nombreArchivo = $_FILES['archivo']['name'];
        $tempArchivo = $_FILES['archivo']['tmp_name'];

        if (pathinfo($nombreArchivo, PATHINFO_EXTENSION) === 'csv') {
            // Lee el archivo CSV y procesa los datos
            $handle = fopen($tempArchivo, 'r');

            if ($handle !== false) {
                $stmt = $conn->prepare("INSERT INTO presupuestos (cliente, descripcion, monto, fecha) VALUES (?, ?, ?, NOW())");

                if ($stmt) {
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        $cliente = $data[0];
                        $descripcion = $data[1];
                        $monto = $data[2];

                        $stmt->bind_param("ssd", $cliente, $descripcion, $monto);
                        $stmt->execute();
                    }

                    fclose($handle);
                    echo "Importación exitosa.";
                } else {
                    echo "Error en la consulta preparada.";
                }

                $stmt->close();
            } else {
                echo "Error al abrir el archivo.";
            }
        } else {
            echo "El archivo debe ser un archivo CSV válido.";
        }
    } else {
        echo "No se seleccionó un archivo o hubo un error al cargar el archivo.";
    }
}
?>

