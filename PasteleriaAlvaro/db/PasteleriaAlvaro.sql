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
    relleno VARCHAR(255),
    imagen VARCHAR(255) -- Campo para la imagen
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

-- Insertar productos con imágenes
INSERT INTO productos (nombre, precio, categoria, tipo, relleno, imagen) 
VALUES 
    ('Tarta Chocolate', 20.00, 'Tartas', 'Tarta', 'Chocolate', 'img/tartaChocolate.jpg'),
    ('Tarta Fresa', 18.00, 'Tartas', 'Tarta', 'Fresa', 'img/tartaFresa.jpg'),
    ('Tarta Limón', 19.00, 'Tartas', 'Tarta', 'Limón', 'img/tartaLimon.jpg'),
    
    ('Bollo de Crema', 3.50, 'Bollos', 'Bollo', 'Crema', 'img/bolloCrema.jpg'),
    ('Palmera de Crema', 3.50, 'Bollos', 'Bollo', 'Crema', 'img/palmeraCrema.jpg'),
    ('Palmera de Chocolate', 3.75, 'Bollos', 'Bollo', 'Chocolate', 'img/palmeraChocolate.jpg'),
    
    ('Chocolate Amargo', 2.00, 'Chocolate', 'Chocolate', 'Amargo', 'img/chocolateAmargo.jpg'),
    ('Chocolate Blanco', 2.50, 'Chocolate', 'Chocolate', 'Blanco', 'img/chocolateBlanco.jpg'),
    ('Chocolate con Leche', 2.25, 'Chocolate', 'Chocolate', 'Leche', 'img/chocolateLeche.jpg'),
    
    ('Churros con Chocolate', 6.00, 'Dulces', 'Dulces', 'Chocolate', 'img/churrosChocolate.jpg'),
    ('Croissant de Nutella', 2.50, 'Dulces', 'Dulces', 'Nutella', 'img/croissantNutella.jpg'),
    ('Polvorones de Leche Condensada', 5.50, 'Dulces', 'Polvorón', 'Leche Condensada', 'img/polvoronesLeche.jpg');
