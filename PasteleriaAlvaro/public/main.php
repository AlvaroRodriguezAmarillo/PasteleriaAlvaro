<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === 'admin') {
    header('Location: index.php');
    exit;
}

// Incluir la clase de conexión
require_once __DIR__ . '/../src/Conexion.php';

$conexion = Conexion::obtenerInstancia()->obtenerConexion();

// Obtener el nombre del usuario
$usuario = $_SESSION['usuario'];

// Lógica para agregar productos al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
    $producto_nombre = $_POST['producto_nombre'];
    $producto_precio = $_POST['producto_precio'];

    // Conectar a la base de datos para guardar en el carrito
    try {
        // Verificar si el producto ya existe en el carrito
        $sql = "SELECT cantidad FROM pedidos 
                WHERE cliente_id = (SELECT id FROM clientes WHERE usuario = :usuario)
                AND producto_id = :producto_id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':usuario' => $usuario,
            ':producto_id' => $producto_id
        ]);
        $productoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($productoExistente) {
            // Si el producto ya existe, incrementar la cantidad
            $sql = "UPDATE pedidos 
                    SET cantidad = cantidad + 1
                    WHERE cliente_id = (SELECT id FROM clientes WHERE usuario = :usuario)
                    AND producto_id = :producto_id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':usuario' => $usuario, ':producto_id' => $producto_id]);
        } else {
            // Si el producto no existe, insertarlo con cantidad 1
            $sql = "INSERT INTO pedidos (cliente_id, producto_id, cantidad) 
                    VALUES ((SELECT id FROM clientes WHERE usuario = :usuario), :producto_id, 1)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':usuario' => $usuario, ':producto_id' => $producto_id]);
        }
    } catch (PDOException $e) {
        die("Error al agregar producto al carrito: " . $e->getMessage());
    }
}

// Obtener productos de la base de datos
try {
    $sql = "SELECT id, nombre, precio, categoria, tipo, relleno, imagen FROM productos";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}

// Obtener el número de productos en el carrito
$sql = "SELECT COUNT(*) FROM pedidos WHERE cliente_id = (SELECT id FROM clientes WHERE usuario = :usuario)";
$stmt = $conexion->prepare($sql);
$stmt->execute([':usuario' => $usuario]);
$cantidadCarrito = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Fuente personalizada -->
    <link href="css/style2.css" rel="stylesheet"> <!-- Enlace al archivo CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="js/cookie.js" defer></script>

</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h1>
        <div class="mt-3">
            <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            <a href="carrito.php" class="btn btn-secondary position-relative">
                <i class="fas fa-shopping-cart"></i> Ver mi carrito
                <?php if ($cantidadCarrito > 0): ?>
                    <span class="cart-notification"><?php echo $cantidadCarrito; ?></span>
                <?php endif; ?>
            </a>
        </div>

        <h2 class="mt-4">Productos Disponibles</h2>

        <?php if (!empty($productos)) : ?>
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                <?php foreach ($productos as $producto) : ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                 class="card-img-top" 
                                 alt="Imagen de <?php echo htmlspecialchars($producto['nombre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($producto['precio']); ?> €</p>
                                <p class="card-text"><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria']); ?></p>
                                <p class="card-text"><strong>Tipo:</strong> <?php echo htmlspecialchars($producto['tipo']); ?></p>
                                <p class="card-text"><strong>Relleno:</strong> <?php echo htmlspecialchars($producto['relleno']); ?></p>
                                <form action="" method="POST">
                                    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                    <input type="hidden" name="producto_nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                    <input type="hidden" name="producto_precio" value="<?php echo htmlspecialchars($producto['precio']); ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart"></i> Añadir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
            