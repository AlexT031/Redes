<?php

include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $id_marca = $_POST['id_marca'];

    $stmt = $conn->prepare("INSERT INTO productos (nombre, codigo, id_marca) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nombre, $codigo, $id_marca);

    if ($stmt->execute()) {
        echo "Producto agregado exitosamente";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
