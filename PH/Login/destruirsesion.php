<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}
?>
<?php
session_start();
session_destroy();
header("Location: formularioDeLogin.html");
exit();
?>
