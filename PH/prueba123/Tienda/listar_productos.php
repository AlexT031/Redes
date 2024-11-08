<?php
include 'conexion.php';

// Recibir la entrada JSON del cliente
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Construir la consulta SQL con filtros dinámicos
$query = "SELECT * FROM productos"; // Ajusta a tu tabla

$conditions = [];
$params = [];

// Aplicar filtros si existen
if (!empty($data['nombre'])) {
    $conditions[] = "nombre LIKE ?";
    $params[] = '%' . $data['nombre'] . '%';
}
if (!empty($data['categoria'])) {
    $conditions[] = "categoria = ?";
    $params[] = $data['categoria'];
}
if (!empty($data['precio_min'])) {
    $conditions[] = "precio >= ?";
    $params[] = $data['precio_min'];
}
if (!empty($data['precio_max'])) {
    $conditions[] = "precio <= ?";
    $params[] = $data['precio_max'];
}

// Concatenar condiciones a la consulta principal
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver el resultado como JSON
header('Content-Type: application/json');
echo json_encode($results);
