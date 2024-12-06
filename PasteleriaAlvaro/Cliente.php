<?php

require_once "Dulces.php";  // Incluir la clase base Dulce

class Cliente {

    // Atributos del cliente
    private $nombre;
    private $numPedidosEfectuados;
    private $dulcesComprados;

    // Constructor
    public function __construct($nombre, $numPedidosEfectuados = 0) {
        $this->nombre = $nombre;
        $this->numPedidosEfectuados = $numPedidosEfectuados;
        $this->dulcesComprados = [];
    }

    // Métodos getters
    public function getNumPedidosEfectuados() {
        return $this->numPedidosEfectuados;
    }

    public function getNombre() {
        return $this->nombre;
    }

    // Método para mostrar resumen del cliente
    public function muestraResumen() {
        return "Cliente: " . $this->getNombre() . "<br>" .
               "Número de pedidos efectuados: " . $this->getNumPedidosEfectuados() . "<br>";
    }

    // Método para comprar un dulce
    public function comprar(Dulce $d) {
        // Verificar si el dulce ya fue comprado
        if (!in_array($d, $this->dulcesComprados)) {
            $this->dulcesComprados[] = $d;  // Agregar el dulce al array de comprados
            $this->numPedidosEfectuados++;
            echo "Has comprado el dulce: " . $d->getNombre() . ".<br>";
            echo "Total de pedidos: " . $this->getNumPedidosEfectuados() . ".<br>";
        } else {
            echo "Ya has comprado el dulce: " . $d->getNombre() . ".<br>";
        }
    }

    // Método para listar los pedidos
    public function listarPedidos() {
        echo "Pedidos realizados por " . $this->getNombre() . ":<br>";
        foreach ($this->dulcesComprados as $dulce) {
            echo "- " . $dulce->getNombre() . "<br>";
        }
    }
}
?>
