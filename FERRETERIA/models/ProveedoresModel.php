<?php

class ProveedoresModel extends ModelBase {

    public function __construct() {
        parent::__construct();
    }

    public function insert($razonSocial, $direccion, $telefono) {
        try {
            $query = "INSERT INTO proveedores (razonSocial, direccion, telefono) VALUES (:razon, :direccion, :telefono)";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':razon', $razonSocial);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Insert Proveedor Error: " . $e->getMessage());
            return false;
        }
    }

    public function read() {
        try {
            $stmt = $this->db->connect()->prepare("SELECT * FROM proveedores ORDER BY proveedorId DESC");
            $stmt->execute();
            $proveedores = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $proveedores[] = [
                    'proveedorId' => $row['proveedorId'],
                    'razonSocial' => $row['razonSocial'],
                    'direccion' => $row['direccion'],
                    'telefono' => $row['telefono']
                ];
            }

            return $proveedores;
        } catch (PDOException $e) {
            error_log("Read Proveedor Error: " . $e->getMessage());
            return [];
        }
    }

    public function update($id, $razonSocial, $direccion, $telefono) {
        try {
            $query = "UPDATE proveedores SET razonSocial = :razon, direccion = :direccion, telefono = :telefono WHERE proveedorId = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':razon', $razonSocial);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Proveedor Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->connect()->prepare("DELETE FROM proveedores WHERE proveedorId = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete Proveedor Error: " . $e->getMessage());
            return false;
        }
    }

    public function getLastId() {
        try {
            $stmt = $this->db->connect()->prepare("SELECT proveedorId FROM proveedores ORDER BY proveedorId DESC LIMIT 1");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['proveedorId'] : 0;
        } catch (PDOException $e) {
            error_log("getLastId Proveedor Error: " . $e->getMessage());
            return 0;
        }
    }
}
