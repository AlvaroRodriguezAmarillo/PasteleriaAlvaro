<?php
class Conexion {
    private static $instancia = null;
    private $conexion;

    private $host = 'localhost';
    private $usuario = 'root'; 
    private $password = '1234'; 
    private $baseDatos = 'PasteleriaAlvaro'; 

    private function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->baseDatos}", 
                $this->usuario, 
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }

    public function obtenerConexion() {
        return $this->conexion;
    }

    private function __clone() {}

    public function __wakeup() {}
}
?>
