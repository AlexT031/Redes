<?php

include 'db.php';

$sql = "SELECT id_marca, nombre FROM marcas";
$result = $conn->query($sql);

$marcas = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $marcas[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($marcas);

$conn->close();
?>
