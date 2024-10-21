<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = getDBConnection();
    
    $id_producto = $_POST['id_producto'];
    
    // Eliminar el producto
    $stmt = $db->prepare("DELETE FROM productos WHERE id_producto = :id_producto");
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();
    
    // También eliminar de la tabla de relación
    $stmt = $db->prepare("DELETE FROM productos_locales_marcas WHERE id_producto = :id_producto");
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();
    
    echo "Producto eliminado correctamente.";
}
?>
