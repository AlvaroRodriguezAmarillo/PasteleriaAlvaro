<?php

require_once "Dulces.php";  
require_once "Bollo.php";   
require_once "Chocolate.php"; 
require_once "Tarta.php"; 


class Cliente {

    //Se añaden los atributos
    private $nombre;
    private $numPedidosEfectuados;
    private $dulcesComprados;

    //Se añaden las funciones
    public function __construct($nombre, $numPedidosEfectuados = 0) {
        $this->nombre = $nombre;
        $this->numPedidosEfectuados = $numPedidosEfectuados;
        $this->dulcesComprados = [];
    }

    public function getNumPedidosEfectuados() {
        return $this->numPedidosEfectuados;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function muestraResumen() {
        return "Cliente: " . $this->getNombre() . 
               "<br>Número de pedidos efectuados: " . $this->getNumPedidosEfectuados() . "<br>";
    }


    public function listaDeDulces(Dulce $d) {
        foreach ($this->dulcesComprados as $dulce) {
            if ($dulce->getNombre() === $d->getNombre()) {
                return true;
            }
        }
        return false; 
    }

    // Método para comprar un dulce
    public function comprar(Dulce $d) {
        if ($this->listaDeDulces($d)) {
            echo "<br>Ya has comprado el dulce: " . $d->getNombre() . ".<br>";
            return false; 
        } else {
            $this->dulcesComprados[] = $d;
            $this->numPedidosEfectuados++;
            echo "<br>Has comprado el dulce: " . $d->getNombre() . ".<br>" .
                 "Total de pedidos: " . $this->getNumPedidosEfectuados() . ".<br>";
            return true; 
        }
    }

    public function valorar(Dulce $d, $comentario) {
        if ($this->listaDeDulces($d)) {
            echo "<br>Comentario sobre " . $d->getNombre() . ": " . $comentario . ".<br>";
            return true; 
        } else {
            echo "<br>No has comprado el dulce: " . $d->getNombre() . ", no puedes valorarlo.<br>";
            return false; 
        }
    }

    public function listarPedidos() {
        echo "<br>Total de pedidos realizados por " . $this->getNombre() . ": " . $this->getNumPedidosEfectuados() . "<br>";
        echo "Pedidos realizados:<br>";
        foreach ($this->dulcesComprados as $dulce) {
            echo "- " . $dulce->getNombre() . "<br>";
        }
    }
}

//Se prueba la clase Cliente
$cliente = new Cliente("Alvaro Rodíguez");
$chocolate = new Chocolate("Chocolate Blanco", 3, "Chocolate blanco con leche", "Chocolate", 50, 150);
$bollo = new Bollo("Brioche", 2.5, "Bollo de masa esponjosa", "Bollo", "Crema");

//Se compran 2 dulces
$cliente->comprar($chocolate);
$cliente->comprar($bollo);

//Se Valoran los dulces
$cliente->valorar($chocolate, "Delicioso y suave");
$cliente->valorar($bollo, "Jugoso y esponjoso");


//Se muestran los pedidos realizados
$cliente->listarPedidos();
?>
