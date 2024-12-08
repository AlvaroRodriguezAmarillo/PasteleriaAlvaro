<?php

require_once 'Dulces.php'; 

class Tarta extends Dulce {

    // Se añaden los atributos
    private $rellenos = [];
    private $numPisos;
    private $minNumComensales;
    private $maxNumComensales;

    // Se crea el constructor
    public function __construct($nombre, $precio, $descripcion, $categoria, $numPisos, $rellenos, $minNumComensales = 2, $maxNumComensales = 10) {
        parent::__construct($nombre, $precio, $descripcion, $categoria);
        $this->numPisos = $numPisos;
        $this->rellenos = $rellenos;
        $this->minNumComensales = $minNumComensales;
        $this->maxNumComensales = $maxNumComensales;
    }

    // Se crea la función para mostrar los comensales posibles
    public function muestraComensalesPosibles() {
        if ($this->minNumComensales === $this->maxNumComensales) {
            return "Para " . $this->minNumComensales . " comensales.";
        } else {
            return "De " . $this->minNumComensales . " a " . $this->maxNumComensales . " comensales.";
        }
    }

    // Se implementa el método abstracto muestraResumen
    public function muestraResumen() {
        return "La tarta es la siguiente:<br>" . 
               "Nombre: " . $this->getNombre() . "<br>" . 
               "Precio: " . $this->getPrecio() . " €<br>" . 
               "Descripción: " . $this->getDescripcion() . "<br>" . 
               "Categoría: " . $this->getCategoria() . "<br>" . 
               "Número de pisos: " . $this->numPisos . "<br>" . 
               "Rellenos: " . implode(", ", $this->rellenos) . "<br>" . 
               "Comensales posibles: " . $this->muestraComensalesPosibles() . "<br>" . 
               "IVA: " . self::getIVA() . " %<br>";
    }
}
?>
