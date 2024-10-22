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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>
<body>
    <h1>Agregar un nuevo producto</h1>
    <form action="create.php" method="POST">
        <label for="nombre">Nombre del producto:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="codigo">Código del producto:</label>
        <input type="text" id="codigo" name="codigo" required><br><br>

        <label for="id_marca">Marca del producto (ID):</label>
        <input type="number" id="id_marca" name="id_marca" required><br><br>

        <input type="submit" value="Agregar Producto">
    </form>
</body>
</html>
