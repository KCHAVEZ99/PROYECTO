    <?php

    class LoginController extends ControllerBase {
        function __construct() {
            parent::__construct();
        }

        function render() {
            $this->view->render('Login/index');
        }

        function ingresar() {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
            
            $ingreso = $this->model->validarLogin($usuario, $password);

            if (isset($ingreso)) {
                session_name("LOGIN");
                session_start();
                $_SESSION['TrabajadorId'] = $ingreso[0];
                $_SESSION['Rol'] = $ingreso[1];

                if ($ingreso[1] == 3) {
                    $this->redirect('Stocks/');
                } else {
                    $this->redirect('Venta/');
                }

            } else {
                // Mostrar SweetAlert2 si login falla
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Usuario o contraseña incorrectos',
                        confirmButtonText: 'Intentar de nuevo'
                    }).then(() => {
                        window.location.href = '" . constant('URL') . "Login';
                    });
                </script>";
            }
        }
    }
    ?>
