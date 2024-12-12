<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === 'admin') {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../src/Conexion.php';

$conexion = Conexion::obtenerInstancia()->obtenerConexion();
$usuario = $_SESSION['usuario'];

try {
    $sql = "SELECT p.id, p.nombre, p.precio, SUM(pe.cantidad) AS cantidad
            FROM pedidos pe
            JOIN productos p ON pe.producto_id = p.id
            WHERE pe.cliente_id = (SELECT id FROM clientes WHERE usuario = :usuario)
            GROUP BY p.id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':usuario' => $usuario]);
    $carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener el carrito: " . $e->getMessage());
}

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Fuente personalizada -->
    <link href="css/style4.css" rel="stylesheet">
    <script src="js/cookie.js" defer></script>

    


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
        <div class="total">
            <h3>Total: <?php echo $total; ?> €</h3>
        </div>
        <div class="text-center">
            <button class="btn btn-danger" onclick="cancelarCompra()">Cancelar</button>
            <button class="btn btn-success" onclick="confirmarPago()">Pagar</button>
        </div>
    </div>

    <script src="js/carrito.js" defer></script> <!-- Enlace al archivo JS -->
</body>
</html>
