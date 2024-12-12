<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === 'admin') {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../src/Conexion.php';

$conexion = Conexion::obtenerInstancia()->obtenerConexion();
$usuario = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    try {
        $sql = "DELETE FROM pedidos 
                WHERE producto_id = :producto_id 
                  AND cliente_id = (SELECT id FROM clientes WHERE usuario = :usuario) 
                LIMIT 1";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':producto_id' => $producto_id,
            ':usuario' => $usuario
        ]);
    } catch (PDOException $e) {
        die("Error al eliminar el producto del carrito: " . $e->getMessage());
    }

    header('Location: carrito.php');
    exit;
}

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

$total = array_reduce($carrito, function ($suma, $producto) {
    return $suma + ($producto['precio'] * $producto['cantidad']);
}, 0);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Fuente personalizada -->
    <link href="css/style3.css" rel="stylesheet">
    <script src="js/cookie.js" defer></script>


    
</head>
<body>
    <div class="container mt-5">
        <h1>Carrito de <?php echo htmlspecialchars($usuario); ?></h1>
        <div class="mt-3">
            <a href="main.php" class="btn btn-secondary">Volver a la tienda</a>
            <a href="ticket.php" class="btn btn-success">Pagar compra</a>
        </div>

        <h2 class="mt-4">Productos en tu carrito</h2>

        <?php if (!empty($carrito)) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $producto) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($producto['precio']); ?> €</td>
                            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                            <td>
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total">
                <h3>Total: <?php echo $total; ?> €</h3>
            </div>
        <?php else : ?>
            <p class="empty-cart-message">Tu carrito está vacío.</p>
        <?php endif; ?>
    </div>

    <script src="js/carrito.js" defer></script> 
</body>
</html>
