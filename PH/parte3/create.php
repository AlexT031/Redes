<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Comprobar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $id_marca = $_POST['id_marca'];

    // Verificar si se subió un archivo PDF
    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] == 0) {
        $pdf_name = $_FILES['archivo_pdf']['name'];
        $pdf_tmp = $_FILES['archivo_pdf']['tmp_name'];
        $upload_dir = 'uploads'; // Carpeta donde se subirán los archivos

        // Asegurarse de que la carpeta de subida existe
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Mover el archivo PDF a la carpeta de subida
        $pdf_path = $upload_dir . basename($pdf_name);
        move_uploaded_file($pdf_tmp, $pdf_path);
    } else {
        $pdf_name = null;
    }

    // Insertar el producto en la base de datos con el nombre del PDF
    $sql = "INSERT INTO productos (nombre, codigo, id_marca, archivo_pdf) VALUES ('$nombre', '$codigo', '$id_marca', '$pdf_name')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto agregado exitosamente.'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
