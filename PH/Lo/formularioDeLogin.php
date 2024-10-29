<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Incluye jQuery -->
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form id="loginForm">
            <input type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" required>
            <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <div id="mensaje"></div>
    </div>

    <script>
        $(document).ready(function(){
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Evita el envío tradicional del formulario

                $.ajax({
                    url: 'ingresoAlSistema.php',
                    type: 'POST',
                    data: {
                        nombre: $('#nombre').val(),
                        contrasena: $('#contrasena').val()
                    },
                    success: function(response) {
                        if(response === "success") {
                            window.location.href = 'app_modulo1.php'; // Redirige si es exitoso
                        } else {
                            $('#mensaje').html(response); // Muestra mensaje de error
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
