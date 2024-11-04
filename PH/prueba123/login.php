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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Full viewport height */
            margin: 0;
        }

        /* Contenedor del formulario */
        .login-container {
            background-color: #e8da0e;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            /* Ancho fijo para el formulario */
        }

        /* Estilo para los elementos del formulario */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Estilo para el botón de inicio de sesión */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            /* Color azul */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
            /* Color más oscuro al pasar el mouse */
        }

        /* Estilo para el encabezado */
        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>

<body>
    <h2>Iniciar Sesión</h2>
    <form method="POST" action="">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>

</html>