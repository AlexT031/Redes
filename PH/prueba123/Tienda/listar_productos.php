<?php
include 'conexion.php'; 

$sql = "SELECT p.id_producto, p.nombre, p.codigo, m.nombre AS marca, p.archivo_pdf
        FROM productos p
        JOIN marcas m ON p.id_marca = m.id_marca";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Marca</th>
            <th>PDF</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>';

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_producto']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td>{$row['codigo']}</td>";
        echo "<td>{$row['marca']}</td>";
        echo "<td><button onclick=\"openPdfModal('" . $row["archivo_pdf"] . "')\">PDF</button></td>";
        echo "<td><button onclick=\"openEditModal({$row['id_producto']})\">Modificar</button></td>";
        echo "<td><button onclick=\"eliminarProducto({$row['id_producto']})\">Eliminar</button></td>";
        echo "</tr>";
    }
} else {
    echo '<tr><td colspan="7">No hay productos disponibles.</td></tr>'; // Mensaje si no hay productos
}

$conn->close();
?>
