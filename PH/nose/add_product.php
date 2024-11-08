<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$precio = $_POST['precio'];

$sql = "INSERT INTO productos (nombre, precio) VALUES ('$nombre', '$precio')";

if ($conexion->query($sql) === TRUE) {
    echo "Producto agregado correctamente";
} else {
    echo "Error al agregar el producto: " . $conexion->error;
}
?>
