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
    $nombre = $_POST['nombre'];
    $puesto = $_POST['puesto'];
    $fecha_alta = $_POST['fecha_alta'];
    $salario = $_POST['salario'];
    
    $pdfContent = file_get_contents($_FILES['pdf']['tmp_name']);
    
    $sql = "INSERT INTO empleados (nombre, puesto, fecha_alta, salario, pdf) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$nombre, $puesto, $fecha_alta, $salario, $pdfContent])) {
        echo "Empleado agregado exitosamente.";
    } else {
        echo "Error al agregar empleado.";
    }
}
?>
