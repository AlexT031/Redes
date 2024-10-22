<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT productos.id_producto, productos.nombre, productos.codigo, marcas.nombre AS marca, productos.archivo_pdf 
        FROM productos 
        JOIN marcas ON productos.id_marca = marcas.id_marca 
        WHERE productos.nombre LIKE ? OR productos.codigo LIKE ? OR marcas.nombre LIKE ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$likeSearch = "%$search%";
$stmt->bind_param("sss", $likeSearch, $likeSearch, $likeSearch);
$stmt->execute();
$result = $stmt->get_result();
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
    <form method="GET" action="search.php" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Buscar productos..." value="<?php echo htmlspecialchars($search); ?>" required>
        <input type="submit" value="Buscar">
    </form>

    <table border="1" style="width:100%; text-align:center;">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Marca</th>
            <th>Ver PDF</th>
            <th>Eliminar</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_producto']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['marca']; ?></td>
                    <td>
                        <?php if ($row['archivo_pdf']): ?>
                            <button class="button" onclick="openPdfModal('uploads/<?php echo $row['archivo_pdf']; ?>')">Ver PDF</button>
                        <?php else: ?>
                            No disponible
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="delete.php" method="POST">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No se encontraron productos.</td>
            </tr>
        <?php endif; ?>
    </table>
    <script src="app.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
