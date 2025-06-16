<?php

class ProductosController extends ControllerBase {

    function __construct() {
        parent::__construct();
        $this->isPublic = false;
    }

    function render() {
        if ($this->validarAcceso()) {
            $this->Listar();

            // Cargar proveedores
            require_once 'models/ProveedoresModel.php';
            $proveedorModel = new ProveedoresModel();
            $this->view->proveedores = $proveedorModel->read();

            $this->view->render('Productos/index');
        } else {
            $this->redirect('Login/');
        }
    }

    private function validarAcceso() {
        session_name("LOGIN");
        session_start();
        return isset($_SESSION['Rol']) && $_SESSION['Rol'] == 1;
    }

    function Crear() {
        $mensaje = "";
        $res = false;
        $id = 0;

        if (
            $_SERVER["REQUEST_METHOD"] === "POST" &&
            isset($_POST['codigo'], $_POST['nombre'], $_POST['descripcion'], $_POST['proveedorId']) &&
            isset($_FILES['imagen'])
        ) {
            $codigo = trim($_POST['codigo']);
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $proveedorId = intval($_POST['proveedorId']);
            $imagen = $_FILES['imagen'];

            if ($codigo === '' || $nombre === '' || $descripcion === '') {
                $mensaje = "Todos los campos son obligatorios";
            } else {
                $res = $this->model->insert($codigo, $nombre, $descripcion, $proveedorId, $imagen);
                $id = $this->model->getLastId();
                $mensaje = $res ? "Producto agregado con éxito" : "Error al agregar el producto";
            }
        } else {
            $mensaje = "Solicitud no válida";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $id
        ]);
    }

    function Listar() {
        $res = $this->model->read();
        $this->view->model = $res;
    }

    function Actualizar() {
        $mensaje = "";
        $res = false;

        if (
            $_SERVER["REQUEST_METHOD"] === "POST" &&
            isset($_POST['productoId'], $_POST['codigo'], $_POST['nombre'], $_POST['descripcion'], $_POST['proveedorId'])
        ) {
            $id = intval($_POST['productoId']);
            $codigo = trim($_POST['codigo']);
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $proveedorId = intval($_POST['proveedorId']);
            $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;

            if ($codigo === '' || $nombre === '' || $descripcion === '') {
                $mensaje = "Todos los campos son obligatorios";
            } else {
                $res = $this->model->update($id, $codigo, $nombre, $descripcion, $proveedorId, $imagen);
                $mensaje = $res ? "Producto actualizado con éxito" : "Error al actualizar el producto";
            }
        } else {
            $mensaje = "Datos inválidos";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje
        ]);
    }

    function Eliminar() {
        $res = false;
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['productoId'])) {
            $id = intval($_POST['productoId']);
            $res = $this->model->delete($id);
            $mensaje = $res ? "Producto eliminado correctamente" : "Error al eliminar el producto";
        } else {
            $mensaje = "ID inválido";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['productoId'] ?? 0
        ]);
    }

    function LogOut() {
        session_name("LOGIN");
        session_start();
        session_unset();
        session_destroy();
        $this->redirect('Login/');
    }
}
