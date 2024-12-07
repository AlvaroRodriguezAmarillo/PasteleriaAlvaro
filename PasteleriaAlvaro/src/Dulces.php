<?php

require_once 'Resumible.php'; 

abstract class Dulce implements Resumible {

    //Se crean los atributos
    private $nombre;
    private $precio;
    private $descripcion;
    private $categoria;

    //Se crea la constante para el IVA
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

    //Se implementa el método abstracto que obliga a las clases hijas a implementarlo
    abstract public function muestraResumen();

}
?>
