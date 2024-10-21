<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php';

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];
    $db = getDBConnection();

    // Eliminar archivo PDF asociado
    $stmt = $db->prepare("DELETE FROM pdfs WHERE id_producto = ?");
    $stmt->execute([$id_producto]);

    // Eliminar producto
    $stmt = $db->prepare("DELETE FROM productos WHERE id_producto = ?");
    $stmt->execute([$id_producto]);

    echo "Producto eliminado correctamente.";
}
?>
