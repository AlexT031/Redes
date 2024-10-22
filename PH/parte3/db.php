<?php
$host = 'localhost';  
$dbname = 'u663826865_supermercado';  
$username = 'u663826865_AlexT031';  
$password = '_kvc?Vpc.-ff4C&';  

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
