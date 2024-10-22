<?php
$host = 'localhost';   // Host donde está la base de datos
$dbname = 'u663826865_supermercado';  // Nombre de la base de datos
$username = 'u663826865_AlexT031';  // Usuario de MySQL
$password = '_kvc?Vpc.-ff4C&';  // Contraseña de MySQL

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "Conexión exitosa a la base de datos MySQL";
?>
