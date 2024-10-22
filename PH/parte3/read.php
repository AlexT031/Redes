<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Preparar la consulta SQL para obtener los productos
$sql = "SELECT id_producto, nombre, codigo, id_marca FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Productos</h1>

    <table>
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>ID Marca</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Verificar si se obtuvieron resultados
            if ($result->num_rows > 0) {
                // Mostrar los datos en cada fila
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_producto'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['codigo'] . "</td>";
                    echo "<td>" . $row['id_marca'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay productos disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
