<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    $sql = "SELECT p.id_producto, p.nombre, p.codigo, p.id_marca, p.archivo_pdf
            FROM productos p
            WHERE p.id_producto = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        echo json_encode($producto);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
