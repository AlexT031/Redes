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

    $sql = "DELETE FROM empleados WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$id])) {
        echo "Empleado eliminado exitosamente.";
    } else {
        echo "Error al eliminar empleado.";
    }
}
?>
