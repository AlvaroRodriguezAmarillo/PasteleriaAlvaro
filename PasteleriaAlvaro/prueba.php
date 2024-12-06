<?php

require_once "Dulces.php";
require_once "Cliente.php";
require_once "Pasteleria.php";

//Se crean los dulces
$chocolate = new Dulce("Chocolate Blanco", 3, "Chocolate blanco con leche", "Chocolate");
$bollo = new Dulce("Brioche", 2.5, "Bollo de masa esponjosa", "Bollo");

//Se crean algunos clientes
$cliente1 = new Cliente("Roberto Gómez");
$cliente2 = new Cliente("Alvaro Rodríguez");

//Se crea la pastelería
$pasteleria = new Pasteleria();

//Se incluyen dulces y clientes
$pasteleria->incluirDulce($chocolate);
$pasteleria->incluirDulce($bollo);
$pasteleria->incluirCliente($cliente1);
$pasteleria->incluirCliente($cliente2);

//Se muestran productos
$pasteleria->mostrarProductos();

//Se realizan compras
$cliente1->comprar($chocolate);
$cliente2->comprar($chocolate);
$cliente2->comprar($bollo);

//Se muestran los pedidos
$cliente1->listarPedidos();
$cliente2->listarPedidos();

?>
