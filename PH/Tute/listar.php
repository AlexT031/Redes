<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}

include 'db_connect.php';

// Obtener los filtros de POST
$filtroId = isset($_POST['filtroId']) ? $_POST['filtroId'] : '';
$filtroNombre = isset($_POST['filtroNombre']) ? $_POST['filtroNombre'] : '';
$filtroPuesto = isset($_POST['filtroPuesto']) ? $_POST['filtroPuesto'] : '';
$filtroFecha = isset($_POST['filtroFecha']) ? $_POST['filtroFecha'] : '';
$filtroSalario = isset($_POST['filtroSalario']) ? $_POST['filtroSalario'] : '';

// Construir la consulta SQL con filtros
$query = "SELECT * FROM empleados WHERE 1=1";
if ($filtroId) $query .= " AND id LIKE '%$filtroId%'";
if ($filtroNombre) $query .= " AND nombre LIKE '%$filtroNombre%'";
if ($filtroPuesto) $query .= " AND puesto LIKE '%$filtroPuesto%'";
if ($filtroFecha) $query .= " AND fecha_alta LIKE '%$filtroFecha%'";
if ($filtroSalario) $query .= " AND salario LIKE '%$filtroSalario%'";

$result = $conn->query($query);

echo "<table>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['nombre']}</td>";
    echo "<td>{$row['puesto']}</td>";
    echo "<td>{$row['fecha_alta']}</td>";
    echo "<td>{$row['salario']}</td>";
    echo "<td><button onclick=\"verPDF({$row['id']})\">Ver PDF</button></td>";
    echo "<td><button onclick=\"modificarEmpleado({$row['id']}, '{$row['nombre']}', '{$row['puesto']}', '{$row['fecha_alta']}', {$row['salario']})\">Modificar</button> 
          <button onclick=\"eliminarEmpleado({$row['id']})\">Eliminar</button></td>";
    echo "</tr>";
}
echo "</table>";
?>
