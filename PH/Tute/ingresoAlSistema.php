<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, contador FROM usuarios WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['usuario'] = $user['username'];
        
        $nuevoContador = $user['contador'] + 1;
        $updateSql = "UPDATE usuarios SET contador = :contador WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':contador', $nuevoContador);
        $updateStmt->bindParam(':id', $user['id']);
        $updateStmt->execute();

        $_SESSION['contador'] = $nuevoContador;

        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href = 'formularioDeLogin.html';</script>";
        exit();
    }
} else {
    header("Location: formularioDeLogin.html");
    exit();
}
?>
