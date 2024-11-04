<?php
include 'Tienda/conexion.php';

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Consulta para obtener los datos del usuario
    $sql = "SELECT usuario, contrasena, cantidad_ingresos FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
</head>

<body>
    <h1>Perfil de Usuario</h1>
    <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($user['usuario']); ?></p>
    <p><strong>Contraseña:</strong> <?php echo htmlspecialchars($user['contrasena']); ?></p>
    <p><strong>Cantidad de Ingresos:</strong> <?php echo htmlspecialchars($user['cantidad_ingresos']); ?></p>
    <p>
        <a href="Tienda/index.php">Ir a la Tienda</a>

    </p>
</body>

</html>