<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}

include 'db_connect.php';




$filtroId = isset($_GET['filtroId']) ? $_GET['filtroId'] : '';
$filtroNombre = isset($_GET['filtroNombre']) ? $_GET['filtroNombre'] : '';
$filtroPuesto = isset($_GET['filtroPuesto']) ? $_GET['filtroPuesto'] : '';
$filtroFecha = isset($_GET['filtroFecha']) ? $_GET['filtroFecha'] : '';
$filtroSalario = isset($_GET['filtroSalario']) ? $_GET['filtroSalario'] : '';

$query = "SELECT * FROM empleados";
$conditions = [];

if ($filtroId) $conditions[] = "id LIKE '%$filtroId%'";
if ($filtroNombre) $conditions[] = "nombre LIKE '%$filtroNombre%'";
if ($filtroPuesto) $conditions[] = "puesto = '$filtroPuesto'";
if ($filtroFecha) $conditions[] = "fecha_alta LIKE '%$filtroFecha%'";
if ($filtroSalario) $conditions[] = "salario LIKE '%$filtroSalario%'";

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($query);

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Puesto</th><th>Fecha de Alta</th><th>Salario</th><th>PDF</th><th>Acciones</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['nombre']}</td>";
    echo "<td>{$row['puesto']}</td>";
    echo "<td>{$row['fecha_alta']}</td>";
    echo "<td>{$row['salario']}</td>";
    echo "<td><button onclick=\"verPDF({$row['id']})\">Ver PDF</button></td>";
    echo "<td>
            <button onclick=\"modificarEmpleado({$row['id']}, '{$row['nombre']}', '{$row['puesto']}', '{$row['fecha_alta']}', {$row['salario']})\">Modificar</button>
            <button onclick=\"eliminarEmpleado({$row['id']})\">Eliminar</button>
          </td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
