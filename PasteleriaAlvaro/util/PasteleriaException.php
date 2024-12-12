<?php

// Excepción base para la pastelería
class PasteleriaException extends Exception {
    public function __construct($message = "Ocurrió un error en la pastelería", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
