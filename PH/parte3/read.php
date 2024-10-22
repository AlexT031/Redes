<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Preparar la consulta SQL para obtener los productos
$sql = "SELECT id_producto, nombre, codigo, id_marca FROM productos";
$result = $conn->query($sql);
?>

<table>
    <thead>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>ID Marca</th>
            <th>Acciones</th>
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
                echo "<td>
                        <form action='delete.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id_producto' value='" . $row['id_producto'] . "'>
                            <input type='submit' value='Eliminar' class='button' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este producto?\")'>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay productos disponibles</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
