<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}

include 'db_connect.php';

$filtroId = isset($_GET['filtroId']) ? $_GET['filtroId'] : '';
$filtroConsorcio = isset($_GET['filtroConsorcio']) ? $_GET['filtroConsorcio'] : '';
$filtroLuz = isset($_GET['filtroLuz']) ? $_GET['filtroLuz'] : '';
$filtroAgua = isset($_GET['filtroAgua']) ? $_GET['filtroAgua'] : '';
$filtroFechaRenovacion = isset($_GET['filtroFechaRenovacion']) ? $_GET['filtroFechaRenovacion'] : '';

$query = "SELECT * FROM servicios";
$conditions = [];

if ($filtroId) $conditions[] = "id LIKE :filtroId";
if ($filtroConsorcio) $conditions[] = "consorcio LIKE :filtroConsorcio";
if ($filtroLuz) $conditions[] = "empresa_luz = :filtroLuz";
if ($filtroAgua) $conditions[] = "empresa_agua = :filtroAgua";
if ($filtroFechaRenovacion) $conditions[] = "fecha_renovacion LIKE :filtroFechaRenovacion";

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($query);

if ($filtroId) $stmt->bindValue(':filtroId', "%$filtroId%");
if ($filtroConsorcio) $stmt->bindValue(':filtroConsorcio', "%$filtroConsorcio%");
if ($filtroLuz) $stmt->bindValue(':filtroLuz', $filtroLuz);
if ($filtroAgua) $stmt->bindValue(':filtroAgua', $filtroAgua);
if ($filtroFechaRenovacion) $stmt->bindValue(':filtroFechaRenovacion', "%$filtroFechaRenovacion%");

$stmt->execute();

echo "<table border='1'>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = htmlspecialchars($row['id'], ENT_QUOTES);
    $consorcio = htmlspecialchars($row['consorcio'], ENT_QUOTES);
    $empresa_luz = htmlspecialchars($row['empresa_luz'], ENT_QUOTES);
    $empresa_agua = htmlspecialchars($row['empresa_agua'], ENT_QUOTES);
    $fecha_renovacion = htmlspecialchars($row['fecha_renovacion'], ENT_QUOTES);

    echo "<tr>";
    echo "<td>{$id}</td>";
    echo "<td>{$consorcio}</td>";
    echo "<td>{$empresa_luz}</td>";
    echo "<td>{$empresa_agua}</td>";
    echo "<td>{$fecha_renovacion}</td>";
    echo "<td><button onclick=\"showModalVerPDF('{$id}')\">Ver PDF</button></td>";
    echo "<td>
            <button onclick=\"modificarServicio('{$id}', '{$consorcio}', '{$empresa_luz}', '{$empresa_agua}', '{$fecha_renovacion}')\">Modificar</button>
            <button onclick=\"eliminarServicio('{$id}')\">Eliminar</button>
          </td>";
    echo "</tr>";
}
echo "</table>";
?>
