<?php

require_once "Dulces.php";  

class Bollo extends Dulce {

    //Se añade el relleno
    private $relleno;

    //Se sobrescribe el constructor
    public function __construct($nombre, $precio, $descripcion, $categoria, $relleno) {
        parent::__construct($nombre, $precio, $descripcion, $categoria); 
        $this->relleno = $relleno;
    }

    //Se crea el nuevo método
    public function getRelleno() {
        return $this->relleno;
    }

    //Se sobrescribe el método muestraResumen
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

//Se prueba la clase Bollo
$bollo = new Bollo("Croissant", 1, "Crujiente bollo de hojaldre", "Bollo", "Chocolate");
echo $bollo->muestraResumen();  // Solo se muestra el resumen del bollo

?>
