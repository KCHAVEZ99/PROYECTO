<?php

class IngresosModel extends ModelBase {

    public function __construct() {
        parent::__construct();
    }

    public function insert($fecha, $trabajadorId, $proveedorId) {
        try {
            $query = "INSERT INTO ingresos (fecha, trabajadorid, proveedorid) 
                      VALUES (:fecha, :trabajadorid, :proveedorid)";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':trabajadorid', $trabajadorId);
            $stmt->bindParam(':proveedorid', $proveedorId);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Insert Ingreso Error: " . $e->getMessage());
            return false;
        }
    }

    public function read() {
        try {
            $query = "
                SELECT 
                    i.ingresoid,
                    i.fecha,
                    t.nombre AS trabajador,
                    p.razonSocial AS proveedor
                FROM ingresos i
                INNER JOIN personal t ON i.trabajadorid = t.trabajadorid
                INNER JOIN proveedores p ON i.proveedorid = p.proveedorid
                ORDER BY i.ingresoid DESC
            ";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->execute();

            $ingresos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ingresos[] = [
                    $row['ingresoid'],
                    $row['fecha'],
                    $row['trabajador'],
                    $row['proveedor']
                ];
            }

            return $ingresos;
        } catch (PDOException $e) {
            error_log("Read Ingreso Error: " . $e->getMessage());
            return [];
        }
    }

    public function update($id, $fecha, $trabajadorId, $proveedorId) {
        try {
            $query = "UPDATE ingresos 
                      SET fecha = :fecha, trabajadorid = :trabajadorid, proveedorid = :proveedorid 
                      WHERE ingresoid = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':trabajadorid', $trabajadorId);
            $stmt->bindParam(':proveedorid', $proveedorId);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Ingreso Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM ingresos WHERE ingresoid = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete Ingreso Error: " . $e->getMessage());
            return false;
        }
    }

    public function getLastId() {
        try {
            $query = "SELECT ingresoid FROM ingresos ORDER BY ingresoid DESC LIMIT 1";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['ingresoid'] : 0;
        } catch (PDOException $e) {
            error_log("getLastId Ingreso Error: " . $e->getMessage());
            return 0;
        }
    }
}
