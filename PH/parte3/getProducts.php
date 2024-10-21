<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require 'db.php';

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];
    $db = getDBConnection();

    $stmt = $db->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->execute([$id_producto]);

    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($producto);
}
$productos = [
    ['id_producto' => 1, 'nombre' => 'Manzana', 'codigo' => '001', 'nombre_marca' => 'Marca A'],
    ['id_producto' => 2, 'nombre' => 'Carne', 'codigo' => '002', 'nombre_marca' => 'Marca B'],
    // Agrega más productos según sea necesario
];

echo json_encode($productos);
?>
