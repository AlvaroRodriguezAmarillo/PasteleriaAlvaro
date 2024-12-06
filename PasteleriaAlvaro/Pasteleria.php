<?php

require_once "Dulces.php";  
require_once "Cliente.php";

class Pasteleria {

    //Se crean los atributos
    private $productos = [];
    private $clientes = [];

    //Se crean los metodos
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


}
?>
