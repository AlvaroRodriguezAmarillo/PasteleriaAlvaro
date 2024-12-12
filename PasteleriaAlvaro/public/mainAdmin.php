<?php  
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$usuario = $_SESSION['usuario'];

require_once __DIR__ . '/../src/Conexion.php';

$conexion = Conexion::obtenerInstancia()->obtenerConexion();

// Eliminar producto
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

// Eliminar cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_cliente'])) {
    $clienteId = intval($_POST['cliente_id']);
    try {
        $sqlEliminarCliente = "DELETE FROM clientes WHERE id = :id";
        $stmtEliminarCliente = $conexion->prepare($sqlEliminarCliente);
        $stmtEliminarCliente->bindParam(':id', $clienteId, PDO::PARAM_INT);
        $stmtEliminarCliente->execute();
        $mensaje = "Cliente eliminado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "Error al eliminar el cliente: " . $e->getMessage();
    }
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_cliente'])) {
    $clienteId = intval($_POST['cliente_id']);
    $nombre = $_POST['nombre'];
    $usuarioCliente = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    try {
        $sqlEditarCliente = "UPDATE clientes SET nombre = :nombre, usuario = :usuario, contrasena = :contrasena WHERE id = :id";
        $stmtEditarCliente = $conexion->prepare($sqlEditarCliente);
        $stmtEditarCliente->bindParam(':nombre', $nombre);
        $stmtEditarCliente->bindParam(':usuario', $usuarioCliente);
        $stmtEditarCliente->bindParam(':contrasena', $contrasena);
        $stmtEditarCliente->bindParam(':id', $clienteId, PDO::PARAM_INT);
        $stmtEditarCliente->execute();
        $mensaje = "Cliente actualizado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "Error al actualizar el cliente: " . $e->getMessage();
    }
}

try {
    $sqlProductos = "SELECT id, nombre, precio, categoria, tipo, relleno, imagen FROM productos";
    $stmtProductos = $conexion->prepare($sqlProductos);
    $stmtProductos->execute();
    $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

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
    <script src="js/cookie.js" defer></script>
    <script>
        // Confirmación antes de eliminar
        function confirmarEliminar(message) {
            return confirm(message);
        }
    </script>
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
                                        <button type="submit" name="editar_producto" class="btn btn-primary confirmar-guardar">Guardar</button>
                                        <button type="submit" name="eliminar_producto" class="btn btn-danger" onclick="return confirmarEliminar('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
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

        <h3 class="mt-4">Listado de Clientes</h3>
        <?php if (!empty($usuarios)) : ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $cliente) : ?>
                        <tr>
                            <form method="POST">
                                <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                                <input type="hidden" name="cliente_id" value="<?php echo htmlspecialchars($cliente['id']); ?>">
                                <td>
                                    <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($cliente['nombre']); ?>">
                                </td>
                                <td>
                                    <input type="text" name="usuario" class="form-control" value="<?php echo htmlspecialchars($cliente['usuario']); ?>">
                                </td>
                                <td>
                                    <input type="text" name="contrasena" class="form-control" value="<?php echo htmlspecialchars($cliente['contrasena']); ?>">
                                </td>
                                <td>
                                    <button type="submit" name="editar_cliente" class="btn btn-primary confirmar-guardar">Guardar</button>
                                    <button type="submit" name="eliminar_cliente" class="btn btn-danger" onclick="return confirmarEliminar('¿Estás seguro de que deseas eliminar a este cliente?')">Eliminar</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No hay clientes registrados.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
