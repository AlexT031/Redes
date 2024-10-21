<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = getDBConnection();
    
    // Recibimos los datos del formulario
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $tipo = $_POST['tipo'];
    $id_marca = $_POST['id_marca'];
    $id_local = $_POST['id_local'];
    
    // Subida y encriptación del archivo PDF
    if (isset($_FILES['archivo_pdf'])) {
        $pdfData = file_get_contents($_FILES['archivo_pdf']['tmp_name']);
        
        // Encriptar el PDF (puedes usar alguna clave o método más avanzado)
        $encrypted_pdf = base64_encode($pdfData);
    }
    
    // Insertar el producto en la base de datos
    $stmt = $db->prepare("
        INSERT INTO productos (nombre, codigo, tipo, id_marca, id_local, archivo_pdf)
        VALUES (:nombre, :codigo, :tipo, :id_marca, :id_local, :archivo_pdf)
    ");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':id_marca', $id_marca);
    $stmt->bindParam(':id_local', $id_local);
    $stmt->bindParam(':archivo_pdf', $encrypted_pdf);
    $stmt->execute();
    
    // Insertar en la tabla de relación
    $id_producto = $db->lastInsertId();
    $stmt = $db->prepare("
        INSERT INTO productos_locales_marcas (id_producto, id_marca, id_local)
        VALUES (:id_producto, :id_marca, :id_local)
    ");
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->bindParam(':id_marca', $id_marca);
    $stmt->bindParam(':id_local', $id_local);
    $stmt->execute();
    
    echo "Producto agregado correctamente.";
}
?>
