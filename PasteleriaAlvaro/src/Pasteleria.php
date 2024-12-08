<?php

require_once 'Bollo.php';
require_once 'Chocolate.php';
require_once 'Tarta.php';
require_once 'Cliente.php';
require_once 'Conexion.php';
require_once '../util/PasteleriaException.php';
require_once '../util/DulceNoCompradoException.php';
require_once '../util/DulceNoEncontradoException.php';
require_once '../util/ClienteNoEncontradoException.php';

class Pasteleria {

    //Se crean los atributos para almacenar productos y clientes
    private $productos = [];
    private $clientes = [];

    //Se crea el constructor
    public function __construct() {
        $this->cargarProductos();
        $this->cargarClientes();
    }

    private function cargarProductos() {
        // Conectar a la base de datos
        $pdo = Conexion::conectar();
        
        // Obtener los productos
        $stmt = $pdo->query("SELECT * FROM productos");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Crear instancias de las clases hijas de Dulce según el tipo
            if ($row['tipo'] == 'Tarta') {
                // Aquí asumo que el campo relleno es solo uno, si hay varios, debes ajustarlo
                $producto = new Tarta($row['nombre'], $row['precio'], '', $row['categoria'], 3, [$row['relleno']]); // Pasa los rellenos según los datos
            } elseif ($row['tipo'] == 'Croissant' || $row['tipo'] == 'Bollo') {
                $producto = new Bollo($row['nombre'], $row['precio'], '', $row['categoria'], $row['relleno']);
            } elseif ($row['tipo'] == 'Chocolate') {
                // En este caso, he usado valores predeterminados para el porcentaje de cacao y gramos
                $producto = new Chocolate($row['nombre'], $row['precio'], '', $row['categoria'], 70, 100);
            } else {
                // Si hay otros tipos de productos, maneja aquí la creación del objeto
                continue;
            }

            // Añadir el producto al array de productos
            $this->productos[] = $producto;
        }
    }

    private function cargarClientes() {
        // Conectar a la base de datos
        $pdo = Conexion::conectar();
        
        // Obtener los clientes
        $stmt = $pdo->query("SELECT * FROM clientes");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cliente = new Cliente($row['nombre'], $row['id']);
            $this->clientes[] = $cliente;
        }
    }

    public function incluirDulce(Dulce $dulce) {
        $this->incluirProducto($dulce);
    }

    public function incluirCliente(Cliente $cliente) {
        $this->clientes[] = $cliente;
    }

    private function incluirProducto(Dulce $dulce) {
        $this->productos[] = $dulce;
    }

    public function mostrarProductos() {
        echo "Productos disponibles en la pastelería:<br>";
        foreach ($this->productos as $producto) {
            echo $producto->muestraResumen() . "<br>";
        }
    }

    public function manejarExcepciones() {
        try {
            $this->clientes[0]->comprar($this->productos[0]);
        } catch (DulceNoCompradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (DulceNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (ClienteNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}
?>
