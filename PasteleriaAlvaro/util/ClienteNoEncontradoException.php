<?php

require_once 'PasteleriaException.php';

// Excepción para cuando un cliente no se encuentra en la pastelería
class ClienteNoEncontradoException extends PasteleriaException {
    public function __construct($message = "El cliente no ha sido encontrado", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
