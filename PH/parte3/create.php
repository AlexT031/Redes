<?php
try {
    $db = new PDO('sqlite:C:\supermercado.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $id_marca = $_POST['id_marca'];

    try {
        $sql = "INSERT INTO productos (nombre, codigo, id_marca) VALUES (:nombre, :codigo, :id_marca)";
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':id_marca', $id_marca);

        $stmt->execute();

        echo "Producto agregado exitosamente.";
    } catch (Exception $e) {
        echo "Error al agregar el producto: " . $e->getMessage();
    }
}
?>
