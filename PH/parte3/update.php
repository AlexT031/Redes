<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDBConnection();

    // Obtener datos del formulario
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $id_marca = $_POST['id_marca'];

    // Actualizar el producto en la tabla productos
    $stmt = $db->prepare("UPDATE productos SET nombre = ?, codigo = ?, id_marca = ? WHERE id_producto = ?");
    $stmt->execute([$nombre, $codigo, $id_marca, $id_producto]);

    echo "Producto actualizado correctamente.";
}
?>
