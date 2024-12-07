<?php

require_once '../util/PasteleriaException.php';
require_once '../util/DulceNoCompradoException.php';
require_once '../util/DulceNoEncontradoException.php';
require_once '../util/ClienteNoEncontradoException.php';

class Cliente {

    //Se añaden los atributos
    private $nombre;
    private $numPedidosEfectuados;
    private $dulcesComprados;

    //Se crea el constructor
    public function __construct($nombre, $numPedidosEfectuados = 0) {
        $this->nombre = $nombre;
        $this->numPedidosEfectuados = $numPedidosEfectuados;
        $this->dulcesComprados = [];
    }

    //Se crean las funciones
    public function getNombre() {
        return $this->nombre;
    }

    public function getNumPedidosEfectuados() {
        return $this->numPedidosEfectuados;
    }

    public function comprar(Dulce $d) {
        if (in_array($d, $this->dulcesComprados)) {
            throw new DulceNoCompradoException("Ya has comprado el dulce: " . $d->getNombre());
        } elseif (!$d) {
            throw new DulceNoEncontradoException("El dulce no se encuentra disponible.");
        }

        $this->dulcesComprados[] = $d;
        $this->numPedidosEfectuados++;
        echo "Has comprado el dulce: " . $d->getNombre() . ".<br>";
        return $this;  // Esto permite el encadenamiento de métodos
    }

    public function valorar(Dulce $d, String $comentario) {
        if (!in_array($d, $this->dulcesComprados)) {
            throw new DulceNoCompradoException("No puedes valorar un dulce que no has comprado.");
        }
        echo "Valoración sobre " . $d->getNombre() . ": " . $comentario . "<br>";
        return $this;  
    }

    public function listarPedidos() {
        if (empty($this->dulcesComprados)) {
            throw new DulceNoCompradoException("No has realizado ningún pedido.");
        }
        echo "Pedidos realizados por " . $this->getNombre() . ":<br>";
        foreach ($this->dulcesComprados as $dulce) {
            echo "- " . $dulce->getNombre() . "<br>";
        }
        return $this;  
    }
}
?>
