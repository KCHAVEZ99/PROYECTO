<?php

class CategoriasController extends ControllerBase {

    function __construct() {
        parent::__construct();
        $this->isPublic = false;
    }

    function render() {
        if ($this->validarAcceso()) {
            $this->Listar();
            $this->view->render('Categorias/index');
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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombreCategoria'])) {
            $categoria = trim($_POST['nombreCategoria']);

            if ($categoria === '') {
                $mensaje = "El nombre de la categoría no puede estar vacío";
            } else {
                $res = $this->model->insert($categoria);
                $id = $this->model->getLastId();
                $mensaje = $res ? "Categoría insertada con éxito" : "Error al insertar la categoría";
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
        $res = false;
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['categoriaId'], $_POST['nombreCategoria'])) {
            $id = intval($_POST['categoriaId']);
            $nombre = trim($_POST['nombreCategoria']);

            if ($nombre === '') {
                $mensaje = "El nombre no puede estar vacío";
            } else {
                $res = $this->model->update($id, $nombre);
                $mensaje = $res ? "Categoría actualizada con éxito" : "Error al actualizar categoría";
            }
        } else {
            $mensaje = "Datos inválidos";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['nombreCategoria'] ?? ''
        ]);
    }

    function Eliminar() {
        $res = false;
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['categoriaId'])) {
            $id = intval($_POST['categoriaId']);
            $res = $this->model->delete($id);
            $mensaje = $res ? "Categoría eliminada correctamente" : "Error al eliminar la categoría";
        } else {
            $mensaje = "ID inválido";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['categoriaId'] ?? 0
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
