<?php
include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM productos WHERE nombre LIKE :search OR codigo LIKE :search";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':search', "%$search%");
$stmt->execute();
$productos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Resultados de Búsqueda</h1>
    
    <table id="productTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Marca</th>
                <th>PDF</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['id_producto']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['codigo']; ?></td>
                        <td><?php echo $producto['id_marca']; ?></td>
                        <td><a href="pdfs/<?php echo $producto['archivo_pdf']; ?>" target="_blank">Ver PDF</a></td>
                        <td><button onclick="eliminarProducto(<?php echo $producto['id_producto']; ?>)">Eliminar</button></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron productos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <a href="read.php">Volver a la lista de productos</a>
</body>
</html>
