<?php

require_once "Dulces.php";

class Chocolate extends Dulce {

    //Se añaden los atributos
    private $porcentajeCacao;
    private $peso;

    //Se sobrescribe el constructor 
    public function __construct($nombre, $precio, $descripcion, $categoria, $porcentajeCacao, $peso) {
        parent::__construct($nombre, $precio, $descripcion, $categoria);
        $this->porcentajeCacao = $porcentajeCacao;
        $this->peso = $peso;
    }

    //Se crean los nuevo métodos
    public function getPorcentajeCacao() {
        return $this->porcentajeCacao;
    }

    public function getPeso() {
        return $this->peso;
    }

    //Se sobrescribe el método muestraResumen
    public function muestraResumen() {
        return "El chocolate es el siguiente: " . $this->getNombre() . 
               "\nPrecio: " . $this->getPrecio() . " €" .
               "\nDescripción: " . $this->getDescripcion() . 
               "\nCategoría: " . $this->getCategoria() . 
               "\nPorcentaje de Cacao: " . $this->porcentajeCacao . "%" .
               "\nPeso: " . $this->peso . "g" .
               "\nIVA: " . self::getIVA() . " %\n";
    }
}

//Se prueba la clase Chocolate
$chocolate = new Chocolate("Chocolate Negro", 2, "Chocolate negro 75%", "Chocolate", 70, 100);
echo $chocolate->muestraResumen();

?>
