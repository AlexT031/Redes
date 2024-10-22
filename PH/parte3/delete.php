<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Obtener el ID del producto a eliminar
$id_producto = $_POST['id_producto'];

// Eliminar el producto de la base de datos
$sql = "DELETE FROM productos WHERE id_producto = '$id_producto'";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Producto eliminado exitosamente.'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
