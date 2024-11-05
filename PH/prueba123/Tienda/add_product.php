<?php

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $codigo = trim($_POST['codigo']);
    $id_marca = intval($_POST['id_marca']);

    if (empty($nombre) || empty($codigo) || empty($id_marca)) {
        echo "<script>alert('Todos los campos son obligatorios.');</script>";
        header("Location: index.php");
        exit();
    }

    if (isset($_FILES['archivo_pdf']) && $_FILES['archivo_pdf']['error'] == 0) {
        $pdfData = file_get_contents($_FILES['archivo_pdf']['tmp_name']);
        $archivo_pdf = base64_encode($pdfData);

        $stmt = $conn->prepare("INSERT INTO productos (nombre, codigo, id_marca, archivo_pdf) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nombre, $codigo, $id_marca, $archivo_pdf);
        
        if ($stmt->execute()) {
            echo "<script>alert('Producto agregado correctamente');</script>";
        } else {
            echo "<script>alert('Error al agregar el producto: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error al cargar el archivo PDF.');</script>";
    }

    $productData = [
        "nombre" => $nombre,
        "codigo" => $codigo,
        "id_marca" => $id_marca,
        "archivo_pdf" => $archivo_pdf,
    ];

    $jsonData = json_encode($productData);

    $sqlInfo = "INSERT INTO productos (nombre, codigo, id_marca, archivo_pdf) VALUES ('$nombre', '$codigo', $id_marca, 'Archivo PDF en base64')";

    echo "<script>
            alert('Producto agregado correctamente.\\n\\nDatos en JSON:\\n$jsonData\\n\\nConsulta SQL:\\n$sqlInfo');
          </script>";
    
    header("Location: index.php");
    exit();
}

?>
