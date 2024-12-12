<?php

require_once '../util/PasteleriaException.php';
require_once '../util/DulceNoCompradoException.php';
require_once '../util/DulceNoEncontradoException.php';
require_once '../util/ClienteNoEncontradoException.php';
require_once '../src/Conexion.php'; 

class Cliente {

    //Se añaden los atributos
    private $id; 
    private $nombre;
    private $numPedidosEfectuados;
    private $dulcesComprados;

    //Se crea el constructor
    public function __construct($nombre, $id = null, $numPedidosEfectuados = 0) {
        $this->nombre = $nombre;
        $this->id = $id;
        $this->numPedidosEfectuados = $numPedidosEfectuados;
        $this->dulcesComprados = [];
    }

    //Se crean las funciones
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNumPedidosEfectuados() {
        return $this->numPedidosEfectuados;
    }

    public function comprar(Dulce $d) {
        $conexion = Conexion::conectar();
        
        if (in_array($d, $this->dulcesComprados)) {
            throw new DulceNoCompradoException("Ya has comprado el dulce: " . $d->getNombre());
        } elseif (!$d) {
            throw new DulceNoEncontradoException("El dulce no se encuentra disponible.");
        }

        //Insertamos el pedido en la base de datos
        $query = "INSERT INTO pedidos (cliente_id, producto_id, cantidad) VALUES (?, ?, 1)";  
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ii", $this->id, $d->getId());
        if ($stmt->execute()) {
            $this->dulcesComprados[] = $d;  
            $this->numPedidosEfectuados++;
            echo "Has comprado el dulce: " . $d->getNombre() . ".<br>";
        } else {
            throw new PasteleriaException("Error al realizar el pedido.");
        }

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
