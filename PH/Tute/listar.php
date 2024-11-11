<?php
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

if ($filtroId) $conditions[] = "id LIKE :filtroId";
if ($filtroNombre) $conditions[] = "nombre LIKE :filtroNombre";
if ($filtroPuesto) $conditions[] = "puesto = :filtroPuesto";
if ($filtroFecha) $conditions[] = "fecha_alta LIKE :filtroFecha";
if ($filtroSalario) $conditions[] = "salario LIKE :filtroSalario";

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($query);

// Asignar parámetros de los filtros
if ($filtroId) $stmt->bindValue(':filtroId', "%$filtroId%");
if ($filtroNombre) $stmt->bindValue(':filtroNombre', "%$filtroNombre%");
if ($filtroPuesto) $stmt->bindValue(':filtroPuesto', $filtroPuesto);
if ($filtroFecha) $stmt->bindValue(':filtroFecha', "%$filtroFecha%");
if ($filtroSalario) $stmt->bindValue(':filtroSalario', "%$filtroSalario%");

$stmt->execute();

echo "<table border='1'>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
?>
