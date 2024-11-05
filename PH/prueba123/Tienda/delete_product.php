<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    $sql = "DELETE FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);

    if ($stmt->execute()) {
        echo "Producto eliminado exitosamente.";
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    
    header("Location: index.php"); 
    exit;
} else {
    echo "ID de producto no proporcionado.";
}
?>
