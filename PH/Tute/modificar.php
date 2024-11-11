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
    $consorcio = $_POST['consorcio'];
    $empresa_luz = $_POST['empresa_luz'];
    $empresa_agua = $_POST['empresa_agua'];
    $fecha_renovacion = $_POST['fecha_renovacion'];

    $sql = "UPDATE empleados SET consorcio = ?, empresa_luz = ?, empresa_agua = ?, fecha_renovacion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$consorcio, $empresa_luz, $empresa_agua, $fecha_renovacion, $id])) {
        echo json_encode([
            "status" => "success",
            "message" => "Consorcio modificado exitosamente.",
            "data" => [
                "id" => $id,
                "consorcio" => $consorcio,
                "empresa_luz" => $empresa_luz,
                "empresa_agua" => $empresa_agua,
                "fecha_renovacion" => $fecha_renovacion
            ]
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error al modificar Consorcio."
        ]);
    }
}
?>
