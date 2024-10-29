<?php
$servername = "localhost"; // Host de la base de datos
$username = "u663826865_AlexT031"; // Usuario de la base de datos
$password = "_kvc?Vpc.-ff4C&"; // Contraseña de la base de datos
$dbname = "u663826865_supermercado"; // Nombre de la base de datos


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
