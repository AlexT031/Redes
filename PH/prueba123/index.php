<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="GET" action="">
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="text" name="codigo" placeholder="Código">
        <select name="id_marca">
            <option value="">Seleccione una Marca</option>
            <?php
            $sql = "SELECT * FROM marcas";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_marca']}'>{$row['nombre']}</option>";
            }
            ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <table>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Marca</th>
            <th>PDF</th>
        </tr>
        <?php
        $sql = "SELECT p.id_producto, p.nombre, p.codigo, m.nombre AS marca, p.archivo_pdf
                FROM productos p
                JOIN marcas m ON p.id_marca = m.id_marca";
        
        $conditions = [];
        if (!empty($_GET['nombre'])) $conditions[] = "p.nombre LIKE '%" . $_GET['nombre'] . "%'";
        if (!empty($_GET['codigo'])) $conditions[] = "p.codigo = '" . $_GET['codigo'] . "'";
        if (!empty($_GET['id_marca'])) $conditions[] = "p.id_marca = '" . $_GET['id_marca'] . "'";
        
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id_producto']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['codigo']}</td>";
            echo "<td>{$row['marca']}</td>";
            echo "<td><a href='view_pdf.php?id={$row['id_producto']}'>Ver PDF</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
