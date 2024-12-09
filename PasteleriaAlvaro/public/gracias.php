<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias por tu compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Fuente personalizada -->
    <link href="css/style5.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="text-center">
            <h1>¡Gracias por confiar en nosotros!</h1>
            <p>Tu pedido ha sido procesado exitosamente. ¡Gracias por tu compra!</p>
            <a href="main.php" class="btn btn-primary">Volver a la tienda</a>
        </div>
    </div>
</body>
</html>
