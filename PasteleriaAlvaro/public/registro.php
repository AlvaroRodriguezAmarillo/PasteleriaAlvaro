<?php
session_start();
require_once __DIR__ . '/../src/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];

    try {
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();

        $sql = "SELECT COUNT(*) FROM clientes WHERE usuario = :usuario";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = "El usuario ya existe.";
            header('Location: registro.php');
            exit;
        }

        $sql = "INSERT INTO clientes (nombre, usuario, contrasena) VALUES (:nombre, :usuario, :contrasena)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':usuario' => $usuario,
            ':contrasena' => $contrasena,
        ]);

        $_SESSION['success'] = "Usuario registrado con éxito. Por favor, inicia sesión.";
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        die("Error al registrar usuario: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Registrate</h1>
        <?php 
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="registro.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>

            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required><br>

            <button type="submit">Crear cuenta</button>
        </form>
        <a href="index.php"><button class="btn-login">Inicia sesión aquí</button></a>
    </div>
</body>
</html>
