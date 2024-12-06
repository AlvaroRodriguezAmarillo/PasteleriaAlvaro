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

    //Se crean los nuevos métodos
    public function getPorcentajeCacao() {
        return $this->porcentajeCacao;
    }

    public function getPeso() {
        return $this->peso;
    }

    //Se sobrescribe el método muestraResumen
    public function muestraResumen() {
        return "El chocolate es el siguiente:<br>" . 
               "Nombre: " . $this->getNombre() . "<br>" .
               "Precio: " . $this->getPrecio() . " €<br>" .
               "Descripción: " . $this->getDescripcion() . "<br>" .
               "Categoría: " . $this->getCategoria() . "<br>" .
               "Porcentaje de Cacao: " . $this->porcentajeCacao . "%<br>" .
               "Peso: " . $this->peso . "g<br>" .
               "IVA: " . self::getIVA() . " %<br>";
    }
}

//Se prueba la clase Chocolate
$chocolate = new Chocolate("Chocolate Negro", 2, "Chocolate negro 75%", "Chocolate", 75, 100);
echo $chocolate->muestraResumen();

?>
