<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/index.css">

    <title>ferreteria</title>
</head>
<body>

    <form method="post" id="login" action="<?php echo constant('URL'); ?>Login/ingresar">
        <div class="box">
            <div class="container">
                <div class="top-header">
                    <header>Inicio de sesión</header>
                </div>

                <div class="input-field">
                    <input type="text" class="input" placeholder="Nombre de usuario" required id="usuario"
                           name="usuario" autocomplete="off"> 
                    <i class="bx bx-user"></i>
                </div>

                <div class="input-field">
                    <input type="password" class="input" placeholder="Contraseña" required id="password"
                           name="password">
                    <i class="bx bx-lock-alt"></i>
                </div>

                <div class="input-field">
                    <input type="submit" class="submit" value="Login">
                </div>

                <div class="bottom">
                    <div class="right">
                        <label><a href="#">¿Olvidaste tu contraseña?</a></label>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script src="<?php echo constant('URL'); ?>public/js/LoginApp.js"></script>
</body>
</html>
