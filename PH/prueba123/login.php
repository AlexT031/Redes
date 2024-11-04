<?php
include 'Tienda/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar el usuario y la contraseña
    $sql = "SELECT id, usuario, contrasena, cantidad_ingresos FROM usuarios WHERE usuario = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado, actualizar la cantidad de ingresos
        $user = $result->fetch_assoc();
        $id_usuario = $user['id'];

        // Incrementar el contador de ingresos
        $sql_update = "UPDATE usuarios SET cantidad_ingresos = cantidad_ingresos + 1 WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $id_usuario);
        $stmt_update->execute();

        // Redirigir a la página de perfil
        header("Location: perfil.php?id=$id_usuario");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="login.php">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>

</html>