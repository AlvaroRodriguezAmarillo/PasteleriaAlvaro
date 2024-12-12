<?php

require_once 'PasteleriaException.php';

// Excepción para cuando un cliente intenta interactuar con un dulce no comprado
class DulceNoCompradoException extends PasteleriaException {
    public function __construct($message = "El dulce no ha sido comprado por el cliente", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
