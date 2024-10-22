<?php
include 'db.php';

$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];
$id_marca = $_POST['id_marca'];

$sql = "INSERT INTO productos (nombre, codigo, id_marca) VALUES ('$nombre', '$codigo', '$id_marca')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Producto agregado exitosamente.'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
