<?php

class Database {
    private $host;
    private $db;
    private $user;
    private $password;

    public function __construct()
    {
        $this->host = constant('HOST');
        $this->db = constant('DB');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
    }

    function connect()
    {
        try {
            $conexion = new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8", "{$this->user}", "{$this->password}");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }
}
?>
