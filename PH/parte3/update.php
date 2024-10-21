<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = getDBConnection();
    
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $tipo = $_POST['tipo'];
    $id_marca = $_POST['id_marca'];
    $id_local = $_POST['id_local'];
    
    // Actualizar el producto
    $stmt = $db->prepare("
        UPDATE productos
        SET nombre = :nombre, codigo = :codigo, tipo = :tipo, id_marca = :id_marca, id_local = :id_local
        WHERE id_producto = :id_producto
    ");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':id_marca', $id_marca);
    $stmt->bindParam(':id_local', $id_local);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();
    
    echo "Producto actualizado correctamente.";
}
?>
