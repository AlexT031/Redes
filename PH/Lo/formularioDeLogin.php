<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
    <form action="ingresoAlSistema.php" method="POST">
        <h2>Iniciar Sesión</h2>
        <input type="text" name="nombre" placeholder="Nombre de usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
