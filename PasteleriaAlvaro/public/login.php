<?php
session_start();
require_once __DIR__ . '/../src/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    try {
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();

        //Buscar el usuario en la base de datos
        $sql = "SELECT * FROM clientes WHERE usuario = :usuario";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioEncontrado && $usuarioEncontrado['contrasena'] === $contrasena) {
            $_SESSION['usuario'] = $usuarioEncontrado['usuario'];
            if ($usuarioEncontrado['usuario'] === 'admin') {
                header('Location: mainAdmin.php');
            } else {
                header('Location: main.php'); 
            }
            exit;
        } else {
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";
            header('Location: index.php');
            exit;
        }
    } catch (PDOException $e) {
        die("Error al conectar con la base de datos: " . $e->getMessage());
    }
}
?>
