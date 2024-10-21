<?php
// Conexión a la base de datos SQLite
$db = new PDO('sqlite:database.sqlite');

// Crear tabla si no existe
$db->exec("CREATE TABLE IF NOT EXISTS elements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT
)");

// Manejar solicitudes POST y GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el contenido JSON
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['element'])) {
        // Insertar nuevo elemento
        $stmt = $db->prepare("INSERT INTO elements (name) VALUES (:name)");
        $stmt->bindParam(':name', $data['element']);
        $stmt->execute();
    }
}

// Obtener la lista de elementos
$statement = $db->prepare("SELECT * FROM elements");
$statement->execute();
$elements = $statement->fetchAll(PDO::FETCH_ASSOC);

// Devolver los elementos en formato JSON
header('Content-Type: application/json');
echo json_encode($elements);
?>
