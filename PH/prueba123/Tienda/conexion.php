<?php
$servername = "localhost";
$username = "u663826865_AlexT031";
$password = "_kvc?Vpc.-ff4C&";
$dbname = "u663826865_supermercado";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
