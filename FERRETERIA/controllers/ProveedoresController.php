<?php

class ProveedoresController extends ControllerBase {

    function __construct() {
        parent::__construct();
        $this->isPublic = false;
    }

    function render() {
        if ($this->validarAcceso()) {
            $this->Listar();
            $this->view->render('Proveedores/index');
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

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['razonSocial'])) {
            $razonSocial = trim($_POST['razonSocial']);
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');

            if ($razonSocial === '') {
                $mensaje = "La razón social no puede estar vacía";
            } else {
                $res = $this->model->insert($razonSocial, $direccion, $telefono);
                $id = $this->model->getLastId();
                $mensaje = $res ? "Proveedor agregado con éxito" : "Error al agregar proveedor";
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

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['proveedorId'], $_POST['razonSocial'])) {
            $id = intval($_POST['proveedorId']);
            $razonSocial = trim($_POST['razonSocial']);
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');

            if ($razonSocial === '') {
                $mensaje = "La razón social no puede estar vacía";
            } else {
                $res = $this->model->update($id, $razonSocial, $direccion, $telefono);
                $mensaje = $res ? "Proveedor actualizado correctamente" : "Error al actualizar proveedor";
            }
        } else {
            $mensaje = "Datos inválidos";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['razonSocial'] ?? ''
        ]);
    }

    function Eliminar() {
        $res = false;
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['proveedorId'])) {
            $id = intval($_POST['proveedorId']);
            $res = $this->model->delete($id);
            $mensaje = $res ? "Proveedor eliminado correctamente" : "Error al eliminar proveedor";
        } else {
            $mensaje = "ID inválido";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['proveedorId'] ?? 0
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
