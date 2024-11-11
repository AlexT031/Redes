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
echo "<tr><th>ID</th><th>Nombre</th><th>Puesto</th><th>Fecha de Alta</th><th>Salario</th><th>PDF</th><th>Acciones</th></tr>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = htmlspecialchars($row['id'], ENT_QUOTES);
    $nombre = htmlspecialchars($row['nombre'], ENT_QUOTES);
    $puesto = htmlspecialchars($row['puesto'], ENT_QUOTES);
    $fecha_alta = htmlspecialchars($row['fecha_alta'], ENT_QUOTES);
    $salario = htmlspecialchars($row['salario'], ENT_QUOTES);

    echo "<tr>";
    echo "<td>{$id}</td>";
    echo "<td>{$nombre}</td>";
    echo "<td>{$puesto}</td>";
    echo "<td>{$fecha_alta}</td>";
    echo "<td>{$salario}</td>";
    echo "<td><button onclick=\"verPDF('{$id}')\">Ver PDF</button></td>";
    echo "<td>
            <button onclick=\"showModalModificar('{$id}', '{$nombre}', '{$puesto}', '{$fecha_alta}', {$salario})\">Modificar</button>
            <button onclick=\"eliminarEmpleado('{$id}')\">Eliminar</button>
          </td>";
    echo "</tr>";
}
echo "</table>";
?>
