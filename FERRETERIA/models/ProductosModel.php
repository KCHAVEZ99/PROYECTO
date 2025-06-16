<?php

class ProductosModel extends ModelBase {

    public function __construct() {
        parent::__construct();
    }

    public function insert($codigo, $nombre, $descripcion, $proveedorId, $imagen) {
        try {
            $rutaImagen = null;

            // Guardar imagen si existe
            if ($imagen && $imagen['tmp_name']) {
                $nombreArchivo = uniqid() . "_" . basename($imagen['name']);
                $ruta = "public/img/productos/" . $nombreArchivo;
                if (move_uploaded_file($imagen['tmp_name'], $ruta)) {
                    $rutaImagen = $nombreArchivo;
                }
            }

            $query = "INSERT INTO productos (codigo, nombre, descripcion, imagen, proveedorId)
                      VALUES (:codigo, :nombre, :descripcion, :imagen, :proveedorId)";
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':imagen', $rutaImagen);
            $stmt->bindParam(':proveedorId', $proveedorId);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Insert Producto Error: " . $e->getMessage());
            return false;
        }
    }

    public function read() {
        try {
            $stmt = $this->db->connect()->prepare("SELECT * FROM productos ORDER BY productoId DESC");
            $stmt->execute();
            $productos = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productos[] = [
                    'id' => $row['productoId'],
                    'codigo' => $row['codigo'],
                    'nombre' => $row['nombre'],
                    'descripcion' => $row['descripcion'],
                    'imagen' => $row['imagen'],
                    'proveedorId' => $row['proveedorId']
                ];
            }

            return $productos;
        } catch (PDOException $e) {
            error_log("Read Productos Error: " . $e->getMessage());
            return [];
        }
    }

    public function update($id, $codigo, $nombre, $descripcion, $proveedorId, $imagen = null) {
        try {
            $conexion = $this->db->connect();

            // Si se subió una nueva imagen
            if ($imagen && $imagen['tmp_name']) {
                $nombreArchivo = uniqid() . "_" . basename($imagen['name']);
                $ruta = "public/img/productos/" . $nombreArchivo;
                if (move_uploaded_file($imagen['tmp_name'], $ruta)) {
                    $query = "UPDATE productos SET codigo = :codigo, nombre = :nombre,
                              descripcion = :descripcion, imagen = :imagen, proveedorId = :proveedorId
                              WHERE productoId = :id";
                    $stmt = $conexion->prepare($query);
                    $stmt->bindParam(':imagen', $nombreArchivo);
                } else {
                    return false;
                }
            } else {
                $query = "UPDATE productos SET codigo = :codigo, nombre = :nombre,
                          descripcion = :descripcion, proveedorId = :proveedorId
                          WHERE productoId = :id";
                $stmt = $conexion->prepare($query);
            }

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':proveedorId', $proveedorId);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Producto Error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->connect()->prepare("DELETE FROM productos WHERE productoId = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete Producto Error: " . $e->getMessage());
            return false;
        }
    }

    public function getLastId() {
        try {
            $stmt = $this->db->connect()->prepare("SELECT productoId FROM productos ORDER BY productoId DESC LIMIT 1");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['productoId'] : 0;
        } catch (PDOException $e) {
            error_log("getLastId Producto Error: " . $e->getMessage());
            return 0;
        }
    }
}
