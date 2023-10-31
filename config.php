<?php
$servername = "localhost"; // Cambia esto al nombre de tu servidor MySQL
$username = "root"; // Cambia esto a tu nombre de usuario de MySQL
$password = ""; // Cambia esto a tu contraseña de MySQL
$database = "appdielmo"; // Cambia esto al nombre de tu base de datos

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
