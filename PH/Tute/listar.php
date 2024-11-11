<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}
?>
<?php
sleep(3);

include 'db_connect.php';

$ordenar = isset($_POST['ordenar']) ? $_POST['ordenar'] : 'id';

$sql = "SELECT * FROM empleados OzzRDER BY $ordenar";
$stmt = $conn->prepare($sql);
$stmt->execute();
$empleados = $stmt->fetchAll();

foreach ($empleados as $row) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['nombre'] . "</td>";
    echo "<td>" . $row['puesto'] . "</td>";
    echo "<td>" . $row['fecha_alta'] . "</td>";
    echo "<td>" . $row['salario'] . "</td>";
    echo "<td><button onclick=\"verPDF(" . $row['id'] . ")\">Ver PDF</button></td>";
    echo "<td>
            <button onclick=\"modificarEmpleado(" . $row['id'] . ", '" . $row['nombre'] . "', '" . $row['puesto'] . "', '" . $row['fecha_alta'] . "', " . $row['salario'] . ")\">Modificar</button>
            <button onclick=\"eliminarEmpleado(" . $row['id'] . ")\">Eliminar</button>
          </td>";
    echo "</tr>";
}
?>
