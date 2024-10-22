<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el ID del producto a eliminar
    $id_producto = $_POST['id_producto'];

    // Preparar la consulta SQL para eliminar el producto
    $stmt = $conn->prepare("DELETE FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);

    // Ejecutar la consulta y verificar si se eliminó el producto
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Producto con ID $id_producto eliminado exitosamente.";
        } else {
            echo "No se encontró un producto con ese ID.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
</head>
<body>
    <h1>Eliminar un producto</h1>
    <form action="delete.php" method="POST">
        <label for="id_producto">ID del producto a eliminar:</label>
        <input type="number" id="id_producto" name="id_producto" required><br><br>

        <input type="submit" value="Eliminar Producto">
    </form>
</body>
</html>
