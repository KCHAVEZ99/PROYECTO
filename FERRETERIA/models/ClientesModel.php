<?php

class ClientesModel extends ModelBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($cliente)
    {
        try {
            $query = "INSERT INTO clientes (nombre) VALUES (:nombre)";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':nombre', $cliente, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Insert Cliente Error: " . $e->getMessage());
            return false;
        }
    }

    public function read()
    {
        try {
            $clientes = [];
            $query = "SELECT * FROM clientes ORDER BY clienteId DESC";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $clientes[] = [$row['clienteId'], $row['nombre']];
            }

            return $clientes;
        } catch (PDOException $e) {
            error_log("Read Clientes Error: " . $e->getMessage());
            return [];
        }
    }

    public function update($id, $nombre)
    {
        try {
            $query = "UPDATE clientes SET nombre = :nombre WHERE clienteId = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Cliente Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM clientes WHERE clienteId = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete Cliente Error: " . $e->getMessage());
            return false;
        }
    }

    public function getLastId()
    {
        try {
            $query = "SELECT clienteId FROM clientes ORDER BY clienteId DESC LIMIT 1";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['clienteId'] : 0;
        } catch (PDOException $e) {
            error_log("GetLastId Cliente Error: " . $e->getMessage());
            return 0;
        }
    }
}
