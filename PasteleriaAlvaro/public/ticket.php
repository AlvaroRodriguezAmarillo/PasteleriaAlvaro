<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === 'admin') {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../src/Conexion.php';

$conexion = Conexion::obtenerInstancia()->obtenerConexion();
$usuario = $_SESSION['usuario'];

// Obtener productos del carrito
try {
    $sql = "SELECT p.id, p.nombre, p.precio, pe.cantidad
            FROM pedidos pe
            JOIN productos p ON pe.producto_id = p.id
            WHERE pe.cliente_id = (SELECT id FROM clientes WHERE usuario = :usuario)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':usuario' => $usuario]);
    $carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener el carrito: " . $e->getMessage());
}

// Calcular el total
$total = array_reduce($carrito, function ($suma, $producto) {
    return $suma + ($producto['precio'] * $producto['cantidad']);
}, 0);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="js/carrito.js" defer></script> <!-- Enlace al archivo JS -->
</head>
<body>
    <div class="container mt-5">
        <h1>Ticket de Compra</h1>
        <h2>Productos comprados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $producto) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['precio']); ?> €</td>
                        <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: <?php echo $total; ?> €</h3>
        <br>
        <button class="btn btn-danger" onclick="cancelarCompra()">Cancelar</button>
        <button class="btn btn-success" onclick="confirmarPago()">Pagar</button>
    </div>
</body>
</html>
