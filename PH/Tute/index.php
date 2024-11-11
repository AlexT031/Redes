<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>
    <p>Contador de sesión: <?php echo $_SESSION['contador']; ?></p>
    
    <div>
        <h2>Información de Sesión</h2>
        <p>Identificativo de sesión: <?php echo session_id(); ?></p>
        <p>Login de usuario: <?php echo $_SESSION['usuario']; ?></p>
        <p>Contador de sesión: <?php echo $_SESSION['contador']; ?></p>
    </div>

    <form action="App_modulo1.php" method="post">
        <button type="submit">Ingrese a la aplicación</button>
    </form>
    
    <form action="destruirsesion.php" method="post">
        <button type="submit">Terminar sesión</button>
    </form>
</body>
</html>
