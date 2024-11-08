<?php
include 'conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];

$sql = "UPDATE productos SET nombre='$nombre', precio='$precio' WHERE id='$id'";

if ($conexion->query($sql) === TRUE) {
    echo "Producto actualizado correctamente";
} else {
    echo "Error al actualizar el producto: " . $conexion->error;
}
?>
