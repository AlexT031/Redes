<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}

include 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $puesto = $_POST['puesto'];
    $fecha_alta = $_POST['fecha_alta'];
    $salario = $_POST['salario'];

    $sql = "UPDATE empleados SET nombre = ?, puesto = ?, fecha_alta = ?, salario = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$nombre, $puesto, $fecha_alta, $salario, $id])) {
        echo json_encode([
            "status" => "success",
            "message" => "Empleado modificado exitosamente.",
            "data" => [
                "id" => $id,
                "nombre" => $nombre,
                "puesto" => $puesto,
                "fecha_alta" => $fecha_alta,
                "salario" => $salario
            ]
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error al modificar empleado."
        ]);
    }
}
?>
