<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];
$id_marca = $_POST['id_marca'];

// Insertar el producto en la base de datos
$sql = "INSERT INTO productos (nombre, codigo, id_marca) VALUES ('$nombre', '$codigo', '$id_marca')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Producto agregado exitosamente.'); window.location.href='index.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
