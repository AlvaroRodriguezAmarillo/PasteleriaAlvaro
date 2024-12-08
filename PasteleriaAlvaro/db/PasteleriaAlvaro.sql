DROP DATABASE IF EXISTS PasteleriaAlvaro;
CREATE DATABASE IF NOT EXISTS PasteleriaAlvaro;
USE PasteleriaAlvaro;

-- Creación tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(255),
    tipo VARCHAR(50),
    relleno VARCHAR(255)
);

-- Creación tabla de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
);

-- Creación tabla de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Insertar clientes
INSERT INTO clientes (nombre, usuario, contrasena) 
VALUES 
    ('Admin', 'admin', 'admin123'),
    ('Test User', 'testuser', 'test123');

-- Insertar productos (dulces)
INSERT INTO productos (nombre, precio, categoria, tipo, relleno) 
VALUES 
    ('Tarta Chocolate', 20.00, 'Tartas', 'Tarta', 'Chocolate'),
    ('Croissant', 2.50, 'Bollos', 'Croissant', 'Nutella'),
    ('Polvorones', 5.50, 'Galletas', 'Polvorón', 'Leche Condensada'),
    ('Churros Chocolate', 6.00, 'Fogones', 'Churro', 'Chocolate'),
    ('Galletas Avena', 5.00, 'Galletas', 'Galleta', 'Avena'),
    ('Bollo Crema', 3.50, 'Bollos', 'Bollo', 'Crema'),
    ('Palmera Crema', 3.50, 'Bollos', 'Palmera', 'Crema'),
    ('Palmera Chocolate', 3.75, 'Bollos', 'Palmera', 'Chocolate'),
    ('Chocolate Amargo', 2.00, 'Chocolate', 'Chocolate', 'Amargo');
