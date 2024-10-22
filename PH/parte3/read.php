<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Preparar la consulta SQL para obtener los productos
$sql = "SELECT id_producto, nombre, codigo, id_marca FROM productos";
$result = $conn->query($sql);
?>