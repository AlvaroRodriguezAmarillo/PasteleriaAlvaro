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

try {
    // Consultar los productos de la base de datos
    $sql = "SELECT id, nombre, precio, categoria, tipo, relleno, imagen FROM productos";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    // Obtener los resultados
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}

// Obtener el nombre del usuario para mostrar
$usuario = $_SESSION['usuario'];

// Lógica para agregar productos al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
    $producto_nombre = $_POST['producto_nombre'];
    $producto_precio = $_POST['producto_precio'];

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Agregar producto al carrito
    $_SESSION['carrito'][] = [
        'id' => $producto_id,
        'nombre' => $producto_nombre,
        'precio' => $producto_precio
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h1>
        <a href="logout.php" class="btn btn-danger mt-2">Cerrar sesión</a>

        <h2 class="mt-4">Productos Disponibles</h2>

        <?php if (!empty($productos)) : ?>
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                <?php foreach ($productos as $producto) : ?>
                    <div class="col">
                        <div class="card h-100">
                            <!-- Ruta de la imagen -->
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
