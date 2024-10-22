<?php
include 'db.php';

$id_producto = $_POST['id_producto'];

$sql = "DELETE FROM productos WHERE id_producto = '$id_producto'";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Producto eliminado exitosamente.'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
