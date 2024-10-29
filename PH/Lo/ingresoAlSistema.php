<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT id_usuario, contrasena FROM usuarios WHERE nombre = :nombre LIMIT 1");
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->execute();

    // Obtener todos los resultados como un array
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar que se haya encontrado un usuario y que la contraseña coincida
    if (count($usuarios) > 0 && password_verify($contrasena, $usuarios[0]['contrasena'])) {
        $_SESSION['user_id'] = $usuarios[0]['id_usuario'];
        echo "success"; // Respuesta para AJAX en caso de autenticación exitosa
    } else {
        echo "Usuario o contraseña incorrectos."; // Mensaje de error en caso de fallo
    }
}
?>
