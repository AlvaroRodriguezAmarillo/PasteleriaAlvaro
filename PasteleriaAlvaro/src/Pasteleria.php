<?php

require_once 'Cliente.php';
require_once 'Dulces.php';
require_once '../util/PasteleriaException.php';
require_once '../util/DulceNoCompradoException.php';
require_once '../util/DulceNoEncontradoException.php';
require_once '../util/ClienteNoEncontradoException.php';    

class Pasteleria {

    //Se crean los atributos para almacenar productos y clientes
    private $productos = [];
    private $clientes = [];

    //Se crean las funciones
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
