<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php';

$db = getDBConnection();

// Consulta para obtener todas las marcas
$stmt = $db->query("SELECT id_marca, nombre FROM marcas");
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Enviar las marcas en formato JSON
header('Content-Type: application/json');
echo json_encode($marcas);
?>
