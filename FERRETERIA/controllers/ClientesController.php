<?php

class ClientesController extends ControllerBase {

    function __construct() {
        parent::__construct();
        $this->isPublic = false;
    }

    function render() {
        if ($this->validarAcceso()) {
            $this->Listar();
            $this->view->render('Clientes/index');
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

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nombreCliente'])) {
            $cliente = trim($_POST['nombreCliente']);

            if ($cliente === '') {
                $mensaje = "El nombre del cliente no puede estar vacío";
            } else {
                $res = $this->model->insert($cliente);
                $id = $this->model->getLastId();
                $mensaje = $res ? "Cliente agregado con éxito" : "Error al agregar cliente";
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

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['clienteid'], $_POST['nombreCliente'])) {
            $id = intval($_POST['clienteid']);
            $nombre = trim($_POST['nombreCliente']);

            if ($nombre === '') {
                $mensaje = "El nombre no puede estar vacío";
            } else {
                $res = $this->model->update($id, $nombre);
                $mensaje = $res ? "Cliente actualizado correctamente" : "Error al actualizar cliente";
            }
        } else {
            $mensaje = "Datos inválidos";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['nombreCliente'] ?? ''
        ]);
    }

    function Eliminar() {
        $res = false;
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['clienteid'])) {
            $id = intval($_POST['clienteid']);
            $res = $this->model->delete($id);
            $mensaje = $res ? "Cliente eliminado correctamente" : "Error al eliminar cliente";
        } else {
            $mensaje = "ID inválido";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['clienteid'] ?? 0
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
