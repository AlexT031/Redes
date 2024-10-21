<?php
require 'db.php';

$db = getDBConnection();

$query = $db->query("
    SELECT productos.nombre AS producto, productos.codigo, productos.tipo, marcas.nombre AS marca, locales.nombre AS local
    FROM productos
    JOIN marcas ON productos.id_marca = marcas.id_marca
    JOIN locales ON productos.id_local = locales.id_local
");

$productos = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($productos);
?>
