<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDBConnection();

    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $id_marca = $_POST['id_marca'];

    // Insertar producto en la tabla productos
    $stmt = $db->prepare("INSERT INTO productos (nombre, codigo, id_marca) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $codigo, $id_marca]);
    $id_producto = $db->lastInsertId();

    // Manejo de archivo PDF
    if (isset($_FILES['pdf']['tmp_name']) && $_FILES['pdf']['size'] > 0) {
        $pdfContent = file_get_contents($_FILES['pdf']['tmp_name']);
        $pdfEncrypted = openssl_encrypt($pdfContent, 'aes-256-cbc', 'tu_clave_secreta', 0, '1234567890123456'); // Cambia la clave y vector según sea necesario

        $pdfName = $_FILES['pdf']['name'];
        $stmt = $db->prepare("INSERT INTO pdfs (nombre_archivo, archivo, id_producto) VALUES (?, ?, ?)");
        $stmt->execute([$pdfName, $pdfEncrypted, $id_producto]);
    }

    // Ejemplo de respuesta exitosa
    $response = [
        'success' => true,
        'message' => 'Producto agregado exitosamente.'
    ];
    
    echo json_encode($response);
    } else {
    $response = [
        'success' => false,
        'message' => 'Método no permitido.'
    ];
    echo json_encode($response);
}
$success = true; // o false, dependiendo del resultado de la operación

echo json_encode(['success' => $success, 'message' => 'Producto agregado exitosamente']);
?>
