<?php
include 'conexion.php';

$id = $_POST['id'];

$sql = "DELETE FROM productos WHERE id='$id'";

if ($conexion->query($sql) === TRUE) {
    echo "Producto eliminado correctamente";
} else {
    echo "Error al eliminar el producto: " . $conexion->error;
}
?>
