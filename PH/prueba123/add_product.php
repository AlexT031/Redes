<?php
// add_product.php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $id_marca = $_POST['id_marca'];
    
    // Procesar el archivo PDF
    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] == 0) {
        $pdfData = file_get_contents($_FILES['archivo_pdf']['tmp_name']);
        $archivo_pdf = base64_encode($pdfData);

        // Insertar en la base de datos
        $stmt = $conn->prepare("INSERT INTO productos (nombre, codigo, id_marca, archivo_pdf) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nombre, $codigo, $id_marca, $archivo_pdf);
        
        if ($stmt->execute()) {
            echo "<script>alert('Producto agregado correctamente');</script>";
        } else {
            echo "<script>alert('Error al agregar el producto: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
    header("Location: index.php");
    exit();
}
?>
