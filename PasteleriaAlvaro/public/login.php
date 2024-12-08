<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Usuarios y contraseñas válidos
    $usuarios_validos = [
        'usuario' => 'usuario', // Usuario normal
        'admin' => 'admin'      // Usuario admin
    ];

    // Validar credenciales
    if (isset($usuarios_validos[$usuario]) && $usuarios_validos[$usuario] === $contrasena) {
        $_SESSION['usuario'] = $usuario;

        // Redirigir según el tipo de usuario
        if ($usuario === 'admin') {
            header('Location: mainAdmin.php');
        } else {
            header('Location: main.php');
        }
        exit;
    } else {
        // Error de autenticación
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header('Location: index.php');
        exit;
    }
}
?>
