<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $id_marca = $_POST['id_marca'];

    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] == UPLOAD_ERR_OK) {
        $archivo_pdf = $_FILES['archivo_pdf']['tmp_name'];
        $pdf_content = file_get_contents($archivo_pdf);
        $pdf_base64 = base64_encode($pdf_content);

        $sql = "UPDATE productos SET nombre = ?, codigo = ?, id_marca = ?, archivo_pdf = ? WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $codigo, $id_marca, $pdf_base64, $id_producto);
    } else {
        $sql = "UPDATE productos SET nombre = ?, codigo = ?, id_marca = ? WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $codigo, $id_marca, $id_producto);
    }

    if ($stmt->execute()) {
        echo "Producto actualizado con éxito.";
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    
    header("Location: index.php");
    exit;
} else {
    echo "Método no permitido.";
}
?>
