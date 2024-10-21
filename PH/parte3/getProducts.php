<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require 'db.php';

header('Content-Type: application/json');
$db = new SQLite3('path_to_your_database.db');

$query = "SELECT p.id_producto, p.nombre, p.codigo, m.nombre AS nombre_marca
          FROM producto p
          JOIN marca m ON p.id_marca = m.id_marca";
$result = $db->query($query);

$productos = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $productos[] = $row;
}

echo json_encode($productos);
?>

?>
