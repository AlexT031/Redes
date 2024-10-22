<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Preparar la consulta SQL para obtener las marcas
$sql = "SELECT id_marca, nombre FROM marcas";
$result = $conn->query($sql);

$marcas = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $marcas[] = $row;
    }
}

// Devolver el resultado como JSON
header('Content-Type: application/json');
echo json_encode($marcas);

// Cerrar la conexión a la base de datos
$conn->close();
?>
