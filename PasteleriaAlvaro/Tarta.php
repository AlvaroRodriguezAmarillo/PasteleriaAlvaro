<?php

require_once "Dulces.php";

class Tarta extends Dulce {

    //Se añaden los atributos
    private $rellenos = [];
    private $numPisos;
    private $minNumComensales;
    private $maxNumComensales;

    //Se sobrescribe el constructor
    public function __construct($nombre, $precio, $descripcion, $categoria, $numPisos, $rellenos, $minNumComensales = 2, $maxNumComensales = 10) {
        parent::__construct($nombre, $precio, $descripcion, $categoria);
        $this->numPisos = $numPisos;
        $this->rellenos = $rellenos;
        $this->minNumComensales = $minNumComensales;
        $this->maxNumComensales = $maxNumComensales;
    }

    //Se crea el nuevo metodo
    public function muestraComensalesPosibles() {
        if ($this->minNumComensales === $this->maxNumComensales) {
            return "Para " . $this->minNumComensales . " comensales.";
        } else if ($this->minNumComensales === 2 && $this->maxNumComensales === 10) {
            return "Para dos comensales a " . $this->maxNumComensales . " comensales.";
        } else {
            return "De " . $this->minNumComensales . " a " . $this->maxNumComensales . " comensales.";
        }
    }

    //Se sobrescribe el método muestraResumen
    public function muestraResumen() {
        return "La tarta es la siguiente: " . $this->getNombre() . 
               "\nPrecio: " . $this->getPrecio() . " €" .
               "\nDescripción: " . $this->getDescripcion() . 
               "\nCategoría: " . $this->getCategoria() . 
               "\nNúmero de pisos: " . $this->numPisos . 
               "\nRellenos: " . implode(", ", $this->rellenos) . 
               "\n" . $this->muestraComensalesPosibles() . 
               "\nIVA: " . self::getIVA() . " %\n";
    }
}

//Se prueba la clase Tarta
$rellenos = ["Chocolate", "Frambuesa", "Nata"];
$tarta = new Tarta("Tarta de Bodas", 40, "Tarta grande de bodas con múltiples rellenos", "Tarta", 3, $rellenos, 4, 8);
echo $tarta->muestraResumen();

?>
