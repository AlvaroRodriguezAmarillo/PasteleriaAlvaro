<?php

class Dulce {

    //Propiedades de la clase
    private $nombre;
    private $precio;
    private $descripcion;
    private $categoria;
    private static $IVA = 21;

    //Se crea el constructor
    public function __construct($nombre, $precio, $descripcion, $categoria) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
    }

    //Se crean los métodos
    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public static function getIVA() {
        return self::$IVA;
    }

    //Se crea la funcion para mostrar el resumen 
    public function muestraResumen() {
        return "Nombre: " . $this->getNombre() . "<br>" .
               "Precio: " . $this->getPrecio() . " €<br>" .
               "Descripción: " . $this->getDescripcion() . "<br>" .
               "Categoría: " . $this->getCategoria() . "<br>" .
               "IVA: " . self::getIVA() . " %<br>";
    }
}

?>
