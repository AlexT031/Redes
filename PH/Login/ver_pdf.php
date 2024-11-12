<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}
?>

<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT pdf FROM servicios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $empleado = $stmt->fetch();

    if ($empleado) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="servicio_' . $id . '.pdf"');
        echo $empleado['pdf'];
    } else {
        echo "PDF no encontrado.";
    }
}
?>
