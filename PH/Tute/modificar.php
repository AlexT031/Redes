<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}
?>
<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $puesto = $_POST['puesto'];
    $fecha_alta = $_POST['fecha_alta'];
    $salario = $_POST['salario'];

    $sql = "UPDATE empleados SET nombre = ?, puesto = ?, fecha_alta = ?, salario = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$nombre, $puesto, $fecha_alta, $salario, $id])) {
        echo "Empleado modificado exitosamente.";
    } else {
        echo "Error al modificar empleado.";
    }
}
?>
