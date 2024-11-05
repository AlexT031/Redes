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

        // Consulta SQL y preparación de la inserción
        $stmt = $conn->prepare("INSERT INTO productos (nombre, codigo, id_marca, archivo_pdf) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nombre, $codigo, $id_marca, $archivo_pdf);
        
        if ($stmt->execute()) {
            // Crear un array con los datos del producto
            $productData = [
                "nombre" => $nombre,
                "codigo" => $codigo,
                "id_marca" => $id_marca,
                "archivo_pdf" => $archivo_pdf,
            ];

            // Convertir los datos a JSON
            $jsonData = json_encode($productData);

            // Crear la consulta SQL en formato texto
            $sqlInfo = "INSERT INTO productos (nombre, codigo, id_marca, archivo_pdf) VALUES ('$nombre', '$codigo', $id_marca, 'Archivo PDF en base64')";

            // Mostrar alerta con JSON y consulta SQL
            echo "<script>
                    alert('Producto agregado correctamente.\\n\\nDatos en JSON:\\n$jsonData\\n\\nConsulta SQL:\\n$sqlInfo');
                  </script>";
        } else {
            echo "<script>alert('Error al agregar el producto: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error al cargar el archivo PDF.');</script>";
    }

    header("Location: index.php");
    exit();
}
?>
