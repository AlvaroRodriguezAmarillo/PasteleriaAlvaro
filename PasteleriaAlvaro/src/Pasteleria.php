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
        $pdo = Conexion::conectar();
        
        $stmt = $pdo->query("SELECT * FROM productos");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['tipo'] == 'Tarta') {
                $producto = new Tarta($row['nombre'], $row['precio'], '', $row['categoria'], 3, [$row['relleno']]); 
            } elseif ($row['tipo'] == 'Croissant' || $row['tipo'] == 'Bollo') {
                $producto = new Bollo($row['nombre'], $row['precio'], '', $row['categoria'], $row['relleno']);
            } elseif ($row['tipo'] == 'Chocolate') {
                $producto = new Chocolate($row['nombre'], $row['precio'], '', $row['categoria'], 70, 100);
            } else {
                continue;
            }

            $this->productos[] = $producto;
        }
    }

    private function cargarClientes() {
        $pdo = Conexion::conectar();
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
