<?php
require 'db.php';

$db = getDBConnection();
$stmt = $db->query("
    SELECT p.id_producto, p.nombre AS producto, p.codigo, m.nombre AS marca
    FROM productos p
    LEFT JOIN marcas m ON p.id_marca = m.id_marca
");

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($productos);
?>
