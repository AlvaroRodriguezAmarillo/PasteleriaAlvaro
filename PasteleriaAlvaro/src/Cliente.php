<?php

require_once 'Dulces.php'; 

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
    public function getNumPedidosEfectuados() {
        return $this->numPedidosEfectuados;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function muestraResumen() {
        return "Cliente: " . $this->getNombre() . "<br>" .
               "Número de pedidos efectuados: " . $this->getNumPedidosEfectuados() . "<br>";
    }

    public function comprar(Dulce $d) {
        if (!in_array($d, $this->dulcesComprados)) {
            $this->dulcesComprados[] = $d;  
            $this->numPedidosEfectuados++;
            echo "Has comprado el dulce: " . $d->getNombre() . ".<br>";
            echo "Total de pedidos: " . $this->getNumPedidosEfectuados() . ".<br>";
        } else {
            echo "Ya has comprado el dulce: " . $d->getNombre() . ".<br>";
        }
    }

    public function listarPedidos() {
        echo "Pedidos realizados por " . $this->getNombre() . ":<br>";
        foreach ($this->dulcesComprados as $dulce) {
            echo "- " . $dulce->getNombre() . "<br>";
        }
    }
}
?>
