<?php
require 'db.php';
$db = getDBConnection();

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];
    $stmt = $db->prepare("
        SELECT productos.*, marcas.id_marca, locales.id_local 
        FROM productos
        JOIN marcas ON productos.id_marca = marcas.id_marca
        JOIN locales ON productos.id_local = locales.id_local
        WHERE productos.id_producto = :id_producto
    ");
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($producto);
} else {
    $stmt = $db->query("
        SELECT productos.id_producto, productos.nombre AS producto, productos.codigo, productos.tipo, 
               marcas.nombre AS marca, locales.nombre AS local
        FROM productos
        JOIN marcas ON productos.id_marca = marcas.id_marca
        JOIN locales ON productos.id_local = locales.id_local
    ");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($productos);
}
?>
