<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>

    <!-- SweetAlert2 desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery y Bootstrap 5 desde CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/estilosGenerales.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/background.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/navBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script>
        const url = "<?php echo constant('URL') ?>";
    </script>
</head>

<body>

<!-- NAVBAR -->
<nav class="main-menu">
    <ul>
        <li><a href="<?php echo constant('URL') ?>"><i class="fa fa-home fa-2x"></i><span class="nav-text">Menú principal</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Categorias"><i class="fa fa-list fa-2x"></i><span class="nav-text">Categoría</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Clientes"><i class="fa fa-hands-helping fa-2x"></i><span class="nav-text">Clientes</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Facturas"><i class="fa fa-book fa-2x"></i><span class="nav-text">Facturas</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Ingresos"><i class="fa fa-coins fa-2x"></i><span class="nav-text">Ingresos</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Personal"><i class="fa fa-users fa-2x"></i><span class="nav-text">Personal</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Productos"><i class="fa fa-tag fa-2x"></i><span class="nav-text">Productos</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Proveedores"><i class="fa fa-truck fa-2x"></i><span class="nav-text">Proveedores</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Stocks"><i class="fa fa-cubes fa-2x"></i><span class="nav-text">Stocks</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Venta"><i class="fa fa-dollar-sign fa-2x"></i><span class="nav-text">Venta</span></a></li>
    </ul>
    <ul class="logout">
        <li><a href="<?php echo constant('URL') ?>Categorias/LogOut"><i class="fa fa-power-off fa-2x"></i><span class="nav-text">Salir</span></a></li>
    </ul>
</nav>

<!-- CONTENIDO -->
<div class="container mt-5">
    <h1 class="mb-3">Categorías</h1>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#miModal">Nueva categoría</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="CuerpoTabla">
            <?php foreach ($this->model as $row): ?>
                <tr model-target="<?= $row[0] ?>">
                    <td><?= $row[1] ?></td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="Eliminar(<?= $row[0] ?>)">Eliminar</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalActualizar" onclick="Actualizar(<?= $row[0] ?>, '<?= $row[1] ?>')">Actualizar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL CREAR -->
<form id="crearCategoria">
    <div class="modal fade" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="LimpiarCrear()"></button>
                </div>
                <div class="modal-body">
                    <label for="nombreCategoria">Nombre</label>
                    <input type="text" id="nombreCategoria" name="nombreCategoria" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="LimpiarCrear()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- MODAL ACTUALIZAR -->
<form id="actualizarCategoria">
    <div class="modal fade" id="ModalActualizar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="LimpiarActualizar()"></button>
                </div>
                <div class="modal-body">
                    <label for="nombreCategoriaActualizar">Nombre</label>
                    <input type="text" id="nombreCategoriaActualizar" name="nombreCategoria" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="LimpiarActualizar()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- SCRIPTS -->
<script src="<?php echo constant('URL') ?>public/js/categoriaApp.js"></script>
</body>
</html>
