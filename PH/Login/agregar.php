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
    $consorcio = $_POST['consorcio'];
    $empresa_luz = $_POST['empresa_luz'];
    $empresa_agua = $_POST['empresa_agua'];
    $fecha_renovacion = $_POST['fecha_renovacion'];
    
    $pdfContent = file_get_contents($_FILES['pdf']['tmp_name']);
    
    $sql = "INSERT INTO servicios (consorcio, empresa_luz, empresa_agua, fecha_renovacion, pdf) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$consorcio, $empresa_luz, $empresa_agua, $fecha_renovacion, $pdfContent])) {
        echo "Consorcio agregado exitosamente.";
    } else {
        echo "Error al agregar Consorcio.";
    }
}
?>
