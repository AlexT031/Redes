<?php
include 'conexion.php'; 

// Obtener el ID del PDF desde la URL
$pdfId = isset($_GET['pdf_id']) ? intval($_GET['pdf_id']) : 1;

// Recuperar el PDF encriptado desde la base de datos
$stmt = $conn->prepare("SELECT pdf_data FROM pdf_table WHERE id = ?");
$stmt->bind_param("i", $pdfId);
$stmt->execute();
$stmt->bind_result($pdfBase64);
$stmt->fetch();

// Desencriptar el contenido del PDF de Base64 a binario
$pdfContent = base64_decode($pdfBase64);

// Enviar las cabeceras adecuadas para mostrar el PDF en el navegador
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="documento.pdf"');
echo $pdfContent;

$stmt->close();
$conn->close();
?>
