<?php

require_once 'Bollo.php';
require_once 'Chocolate.php';
require_once 'Tarta.php';
require_once 'Cliente.php';
require_once 'Pasteleria.php';
require_once '../util/PasteleriaException.php';
require_once '../util/DulceNoCompradoException.php';
require_once '../util/DulceNoEncontradoException.php';
require_once '../util/ClienteNoEncontradoException.php';

//Se crean objetos 
$bollo = new Bollo("Croissant", 1, "Crujiente bollo de hojaldre", "Bollo", "Chocolate");
$chocolate = new Chocolate("Chocolate Negro", 2, "Chocolate negro 75%", "Chocolate", 75, 100);
$tarta = new Tarta("Tarta de Bodas", 40, "Tarta grande de bodas con múltiples rellenos", "Tarta", 3, ["Chocolate", "Frambuesa", "Nata"], 4, 8);

//Se crean clientes
$cliente1 = new Cliente("Roberto Gómez");
$cliente2 = new Cliente("Alvaro Rodríguez");

//Se crea la pastelería
$pasteleria = new Pasteleria();

//Se incluyen productos
$pasteleria->incluirDulce($bollo);
$pasteleria->incluirDulce($chocolate);
$pasteleria->incluirDulce($tarta);

//Se incluyen clientes
$pasteleria->incluirCliente($cliente1);
$pasteleria->incluirCliente($cliente2);

//Se muestran los productos
$pasteleria->mostrarProductos();

//Se hacen las compras 
$cliente1->comprar($chocolate);
$cliente2->comprar($bollo);
$cliente2->comprar($chocolate);

//Se muestran los pedidos
$cliente1->listarPedidos();
$cliente2->listarPedidos();

?>
