<?php 
session_start();

// Verificar si el usuario está autenticado y es admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Guardar el usuario para mostrar
$usuario = $_SESSION['usuario'];

// Incluir la clase de conexión
require_once __DIR__ . '/../src/Conexion.php';

$conexion = Conexion::obtenerInstancia()->obtenerConexion();

// Manejar eliminación de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto'])) {
    $productoId = intval($_POST['producto_id']);
    try {
        $sqlEliminar = "DELETE FROM productos WHERE id = :id";
        $stmtEliminar = $conexion->prepare($sqlEliminar);
        $stmtEliminar->bindParam(':id', $productoId, PDO::PARAM_INT);
        $stmtEliminar->execute();
        $mensaje = "Producto eliminado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "Error al eliminar el producto: " . $e->getMessage();
    }
}

// Manejar edición de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_producto'])) {
    $productoId = intval($_POST['producto_id']);
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $relleno = $_POST['relleno'];

    try {
        $sqlEditar = "UPDATE productos SET nombre = :nombre, precio = :precio, categoria = :categoria, relleno = :relleno WHERE id = :id";
        $stmtEditar = $conexion->prepare($sqlEditar);
        $stmtEditar->bindParam(':nombre', $nombre);
        $stmtEditar->bindParam(':precio', $precio);
        $stmtEditar->bindParam(':categoria', $categoria);
        $stmtEditar->bindParam(':relleno', $relleno);
        $stmtEditar->bindParam(':id', $productoId, PDO::PARAM_INT);
        $stmtEditar->execute();
        $mensaje = "Producto actualizado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "Error al actualizar el producto: " . $e->getMessage();
    }
}

try {
    // Consultar los productos de la base de datos
    $sqlProductos = "SELECT id, nombre, precio, categoria, tipo, relleno, imagen FROM productos";
    $stmtProductos = $conexion->prepare($sqlProductos);
    $stmtProductos->execute();
    $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

    // Consultar los clientes (usuarios) de la base de datos
    $sqlUsuarios = "SELECT id, nombre, usuario, contrasena FROM clientes";
    $stmtUsuarios = $conexion->prepare($sqlUsuarios);
    $stmtUsuarios->execute();
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style6.css" rel="stylesheet">
    <script src="js/confirmaciones.js" defer></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h1>
        <a href="logout.php" class="btn btn-danger mt-2">Cerrar sesión</a>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info mt-3"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <h2 class="mt-4">Panel de Administración</h2>
        <p>Aquí puedes realizar las funciones de administración.</p>

        <!-- Mostrar productos en tarjetas -->
        <h3 class="mt-4">Productos Disponibles</h3>
        <?php if (!empty($productos)) : ?>
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                <?php foreach ($productos as $producto) : ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                 class="card-img-top" 
                                 alt="Imagen de <?php echo htmlspecialchars($producto['nombre']); ?>">
                            <div class="card-body">
                                <!-- Formulario para editar producto -->
                                <form method="POST" class="mt-3">
                                    <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                                    <div class="mb-2">
                                        <label for="nombre_<?php echo $producto['id']; ?>">Nombre</label>
                                        <input type="text" id="nombre_<?php echo $producto['id']; ?>" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="precio_<?php echo $producto['id']; ?>">Precio</label>
                                        <input type="number" id="precio_<?php echo $producto['id']; ?>" name="precio" class="form-control" step="0.01" value="<?php echo htmlspecialchars($producto['precio']); ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="categoria_<?php echo $producto['id']; ?>">Categoría</label>
                                        <input type="text" id="categoria_<?php echo $producto['id']; ?>" name="categoria" class="form-control" value="<?php echo htmlspecialchars($producto['categoria']); ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="relleno_<?php echo $producto['id']; ?>">Relleno</label>
                                        <input type="text" id="relleno_<?php echo $producto['id']; ?>" name="relleno" class="form-control" value="<?php echo htmlspecialchars($producto['relleno']); ?>">
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" name="editar_producto" class="btn btn-primary me-2 confirmar-guardar">Guardar</button>
                                        <button type="submit" name="eliminar_producto" class="btn btn-danger confirmar-eliminar">Eliminar</button>
                                    </div>
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
