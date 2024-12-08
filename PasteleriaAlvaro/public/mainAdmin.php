<?php
session_start();

// Verificamos si el usuario está autenticado y es admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Guardar el usuario para mostrar
$usuario = $_SESSION['usuario'];

// Incluir la clase de conexión
require_once __DIR__ . '/../src/Conexion.php'; // Ajusta la ruta según sea necesario

$conexion = Conexion::obtenerInstancia()->obtenerConexion();

try {
    // Consultar los productos de la base de datos
    $sqlProductos = "SELECT nombre, precio, categoria, tipo, relleno FROM productos";
    $stmtProductos = $conexion->prepare($sqlProductos);
    $stmtProductos->execute();
    $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

    // Consultar los clientes (usuarios) de la base de datos
    $sqlUsuarios = "SELECT id, nombre, usuario, contrasena FROM clientes"; // Cambié usuarios a clientes
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
    <!-- Vinculamos Bootstrap desde el CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h1>
        <a href="logout.php" class="btn btn-danger mt-2">Cerrar sesión</a>

        <h2 class="mt-4">Panel de Administración</h2>
        <p>Aquí puedes realizar las funciones de administración.</p>

        <!-- Mostrar productos en tarjetas -->
        <h3 class="mt-4">Productos Disponibles</h3>
        <?php if (!empty($productos)) : ?>
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                <?php foreach ($productos as $producto) : ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($producto['precio']); ?> €</p>
                                <p class="card-text"><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria']); ?></p>
                                <p class="card-text"><strong>Tipo:</strong> <?php echo htmlspecialchars($producto['tipo']); ?></p>
                                <p class="card-text"><strong>Relleno:</strong> <?php echo htmlspecialchars($producto['relleno']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>

        <!-- Mostrar clientes en tabla -->
        <h3 class="mt-5">Lista de Clientes</h3>
        <?php if (!empty($usuarios)) : ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Contraseña</th> <!-- Agregué campo de contraseña para mostrar -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['usuario']); ?></td> <!-- Mostramos el campo 'usuario' -->
                            <td><?php echo htmlspecialchars($usuario['contrasena']); ?></td> <!-- Mostramos la contraseña -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No hay clientes registrados.</p>
        <?php endif; ?>
    </div>

    <!-- Vinculamos Bootstrap JS desde el CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
