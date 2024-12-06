<?php

class Dulce {

    //Propiedades de la clase
    private $nombre;
    private $precio;
    private $descripcion;
    private $categoria;

    //Constante para el IVA
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
}

//Se crea un objeto de prueba y se muestran sus propiedades
$dulce = new Dulce("Tarta de Chocolate", 15, "Tarta de chocolate con relleno", "Tarta");

echo "El dulce es el siguiente:\n";
echo "Nombre: " . $dulce->getNombre() . "\n";
echo "Precio: " . $dulce->getPrecio() . " €\n";
echo "Descripción: " . $dulce->getDescripcion() . "\n";
echo "Categoría: " . $dulce->getCategoria() . "\n";
echo "IVA: " . Dulce::getIVA() . " %\n";

?>
