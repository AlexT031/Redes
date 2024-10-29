<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: formularioDeLogin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Módulo 1</title>
</head>
<body>
    <h1>Bienvenido al Módulo 1</h1>
    <p>Esta es una sección protegida.</p>
    <a href="destruirsesion.php">Cerrar sesión</a>
</body>
</html>
