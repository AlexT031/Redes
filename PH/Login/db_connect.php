<?php
$servername = "localhost";
$username = "u663826865_wickan";
$password = "X+uH2*LsfV5";
$dbname = "u663826865_prueba";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
