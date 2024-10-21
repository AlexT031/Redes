<?php
require 'db.php';

$db = getDBConnection();

// Obtener todas las marcas
$marcasStmt = $db->query("SELECT id_marca, nombre FROM marcas");
$marcas = $marcasStmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener todos los locales
$localesStmt = $db->query("SELECT id_local, nombre FROM locales");
$locales = $localesStmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los resultados como JSON
header('Content-Type: application/json');
echo json_encode(['marcas' => $marcas, 'locales' => $locales]);
?>
