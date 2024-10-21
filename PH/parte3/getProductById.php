<?php
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
?>
