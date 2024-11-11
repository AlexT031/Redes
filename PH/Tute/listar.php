<?php
include 'db_connect.php';

// Obtener los filtros (vía GET porque fetch envía la consulta en la URL)
$filtroId = isset($_GET['filtroId']) ? $_GET['filtroId'] : '';
$filtroNombre = isset($_GET['filtroNombre']) ? $_GET['filtroNombre'] : '';
$filtroPuesto = isset($_GET['filtroPuesto']) ? $_GET['filtroPuesto'] : '';
$filtroFecha = isset($_GET['filtroFecha']) ? $_GET['filtroFecha'] : '';
$filtroSalario = isset($_GET['filtroSalario']) ? $_GET['filtroSalario'] : '';

// Construir la consulta SQL
$query = "SELECT * FROM empleados";
$conditions = [];

if ($filtroId) $conditions[] = "id LIKE '%$filtroId%'";
if ($filtroNombre) $conditions[] = "nombre LIKE '%$filtroNombre%'";
if ($filtroPuesto) $conditions[] = "puesto = '$filtroPuesto'";
if ($filtroFecha) $conditions[] = "fecha_alta LIKE '%$filtroFecha%'";
if ($filtroSalario) $conditions[] = "salario LIKE '%$filtroSalario%'";

// Agregar condiciones solo si hay filtros
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($query);

// Generar tabla
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Puesto</th><th>Fecha de Alta</th><th>Salario</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['nombre']}</td>";
    echo "<td>{$row['puesto']}</td>";
    echo "<td>{$row['fecha_alta']}</td>";
    echo "<td>{$row['salario']}</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
