<?php
include 'conexion.php';

$id = $_GET['id'];
$sql = "SELECT archivo_pdf FROM productos WHERE id_producto = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Content-type: application/pdf");
    echo base64_decode($row['archivo_pdf']);
} else {
    echo "PDF no encontrado.";
}
?>
