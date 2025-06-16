<?php

class CategoriasModel extends ModelBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($categoria)
    {
        try {
            $query = "INSERT INTO categorias (nombre) VALUES (:nombre)";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':nombre', $categoria, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Insert Error: " . $e->getMessage());
            return false;
        }
    }

    public function read()
    {
        try {
            $categorias = [];
            $query = "SELECT * FROM categorias ORDER BY categoriaId DESC";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categorias[] = [$row['categoriaId'], $row['nombre']];
            }

            return $categorias;
        } catch (PDOException $e) {
            error_log("Read Error: " . $e->getMessage());
            return [];
        }
    }

    public function update($id, $nombre)
    {
        try {
            $query = "UPDATE categorias SET nombre = :nombre WHERE categoriaId = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM categorias WHERE categoriaId = :id";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete Error: " . $e->getMessage());
            return false;
        }
    }

    public function getLastId()
    {
        try {
            $query = "SELECT categoriaId FROM categorias ORDER BY categoriaId DESC LIMIT 1";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['categoriaId'] : 0;
        } catch (PDOException $e) {
            error_log("getLastId Error: " . $e->getMessage());
            return 0;
        }
    }
}
