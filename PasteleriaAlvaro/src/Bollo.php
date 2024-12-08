<?php

require_once 'Dulces.php'; 

class Bollo extends Dulce {

    // Se añaden los atributos
    private $relleno;

    // Se crea el constructor
    public function __construct($nombre, $precio, $descripcion, $categoria, $relleno) {
        parent::__construct($nombre, $precio, $descripcion, $categoria);
        $this->relleno = $relleno;
    }

    // Se crean las funciones
    public function getRelleno() {
        return $this->relleno;
    }

    // Se implementa el método abstracto muestraResumen
    public function muestraResumen() {
        return "El bollo es el siguiente:<br>" . 
               "Nombre: " . $this->getNombre() . "<br>" . 
               "Precio: " . $this->getPrecio() . " €<br>" . 
               "Descripción: " . $this->getDescripcion() . "<br>" . 
               "Categoría: " . $this->getCategoria() . "<br>" . 
               "Relleno: " . $this->relleno . "<br>" . 
               "IVA: " . self::getIVA() . " %<br>";
    }
}
?>
