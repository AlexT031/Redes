<?php
$servername = "sql100.thsite.top";
$username = "thsi_37542157";
$password = "TbpumB?U";
$dbname = "thsi_37542157_redes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
