<?php
include 'conexion.php'; 

$pdfId = isset($_GET['pdf_id']) ? intval($_GET['pdf_id']) : 1;

$stmt = $conn->prepare("SELECT pdf_data FROM pdf_table WHERE id = ?");
$stmt->bind_param("i", $pdfId);
$stmt->execute();
$stmt->bind_result($pdfBase64);
$stmt->fetch();

$pdfContent = base64_decode($pdfBase64);

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="documento.pdf"');
echo $pdfContent;

$stmt->close();
$conn->close();
?>
