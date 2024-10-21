<?php
require 'db.php';

// Conexión a la base de datos
$db = getDBConnection();

// Consultar todos los productos con sus marcas y locales
$stmt = $db->query("
    SELECT productos.id_producto, productos.nombre AS producto, productos.codigo, productos.tipo, 
           marcas.nombre AS marca, locales.nombre AS local
    FROM productos
    JOIN marcas ON productos.id_marca = marcas.id_marca
    JOIN locales ON productos.id_local = locales.id_local
");

// Obtener todos los resultados
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los datos como JSON
header('Content-Type: application/json');
echo json_encode($productos);
?>
