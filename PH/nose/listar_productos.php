<?php
include 'conexion.php';

$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['precio']}</td>
                <td>
                    <button class='edit-btn' data-id='{$row['id']}'>Editar</button>
                    <button class='delete-btn' data-id='{$row['id']}'>Eliminar</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No hay productos disponibles</td></tr>";
}
?>
