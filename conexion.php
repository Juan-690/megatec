<?php
$host = "localhost";
$usuario = "root";
$password = ""; // Pon tu contraseña de MySQL de XAMPP si tienes una
$base_datos = "megatec_db";

$conn = new mysqli($host, $usuario, $password, $base_datos);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}
?>