<?php

class IngresosController extends ControllerBase {

    function __construct() {
        parent::__construct();
        $this->isPublic = false;
    }

    function render() {
        if ($this->validarAcceso()) {
            $this->Listar();
            $this->view->render('Ingresos/index');
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

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['fecha'], $_POST['trabajadorid'], $_POST['proveedorid'])) {
            $fecha = $_POST['fecha'];
            $trabajadorid = intval($_POST['trabajadorid']);
            $proveedorid = intval($_POST['proveedorid']);

            if ($fecha === '' || $trabajadorid === 0 || $proveedorid === 0) {
                $mensaje = "Todos los campos son obligatorios";
            } else {
                $res = $this->model->insert($fecha, $trabajadorid, $proveedorid);
                $id = $this->model->getLastId();
                $mensaje = $res ? "Ingreso agregado correctamente" : "Error al agregar ingreso";
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

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ingresoid'], $_POST['fecha'], $_POST['trabajadorid'], $_POST['proveedorid'])) {
            $id = intval($_POST['ingresoid']);
            $fecha = $_POST['fecha'];
            $trabajadorid = intval($_POST['trabajadorid']);
            $proveedorid = intval($_POST['proveedorid']);

            if ($fecha === '' || $trabajadorid === 0 || $proveedorid === 0) {
                $mensaje = "Todos los campos son obligatorios";
            } else {
                $res = $this->model->update($id, $fecha, $trabajadorid, $proveedorid);
                $mensaje = $res ? "Ingreso actualizado correctamente" : "Error al actualizar ingreso";
            }
        } else {
            $mensaje = "Datos inválidos";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['ingresoid'] ?? 0
        ]);
    }

    function Eliminar() {
        $res = false;
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ingresoid'])) {
            $id = intval($_POST['ingresoid']);
            $res = $this->model->delete($id);
            $mensaje = $res ? "Ingreso eliminado correctamente" : "Error al eliminar ingreso";
        } else {
            $mensaje = "ID inválido";
        }

        echo json_encode([
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $_POST['ingresoid'] ?? 0
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
