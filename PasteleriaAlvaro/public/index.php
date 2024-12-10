<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Referencia al archivo CSS en la carpeta css -->
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesion</h1>
        <?php 
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="login.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required><br>

            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>
