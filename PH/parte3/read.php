<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Consulta para obtener todos los productos
$sql = "SELECT productos.id_producto, productos.nombre, productos.codigo, marcas.nombre AS marca, productos.archivo_pdf FROM productos 
        JOIN marcas ON productos.id_marca = marcas.id_marca";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' style='width:100%; text-align:center;'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Marca</th>
                <th>Ver PDF</th>
                <th>Eliminar</th>
            </tr>";

    // Mostrar cada producto
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id_producto'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['codigo'] . "</td>
                <td>" . $row['marca'] . "</td>";
        
        if ($row['archivo_pdf']) {
            // Botón para abrir el modal con el PDF
            echo "<td><button class='button' onclick=\"openPdfModal('uploads/" . $row['archivo_pdf'] . "')\">Ver PDF</button></td>";
        } else {
            echo "<td>No disponible</td>";
        }

        echo "<td><form action='delete.php' method='POST'>
                <input type='hidden' name='id_producto' value='" . $row['id_producto'] . "'>
                <input type='submit' value='Eliminar'>
              </form></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay productos.";
}

// Cerrar conexión
$conn->close();
?>
