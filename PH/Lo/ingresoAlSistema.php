<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    $stmt = $conn->prepare("SELECT id_usuario, contrasena FROM usuarios WHERE nombre = :nombre");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['user_id'] = $usuario['id_usuario'];
        header('Location: app_modulo1.php');
        exit();
    } else {
        echo "Usuario o contraseña incorrectos. <a href='formularioDeLogin.php'>Inténtalo de nuevo</a>.";
    }
}
?>
