<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresos</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/estilosGenerales.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/background.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/navBar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const url = "<?php echo constant('URL') ?>";
    </script>
</head>
<body>

<!-- NAVBAR -->
<nav class="main-menu">
    <ul>
        <li><a href="<?php echo constant('URL') ?>"><i class="fa fa-home fa-2x"></i><span class="nav-text">Menú principal</span></a></li>
        <li><a href="<?php echo constant('URL') ?>Ingresos"><i class="fa fa-coins fa-2x"></i><span class="nav-text">Ingresos</span></a></li>
        <!-- ...otros módulos aquí... -->
    </ul>
    <ul class="logout">
        <li><a href="<?php echo constant('URL') ?>Ingresos/LogOut"><i class="fa fa-power-off fa-2x"></i><span class="nav-text">Salir</span></a></li>
    </ul>
</nav>

<!-- CONTENIDO -->
<div class="container mt-5">
    <h1 class="mb-3">Ingresos</h1>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalCrearIngreso">Nuevo ingreso</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Trabajador</th>
                <th>Proveedor</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id="CuerpoTabla">
            <?php foreach ($this->model as $row): ?>
                <tr model-target="<?= $row[0] ?>">
                    <td><?= $row[1] ?></td>
                    <td><?= $row[2] ?></td>
                    <td><?= $row[3] ?></td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="Eliminar(<?= $row[0] ?>)">Eliminar</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalActualizarIngreso"
                                onclick="Actualizar(<?= $row[0] ?>, '<?= $row[1] ?>', '<?= $row[2] ?>', '<?= $row[3] ?>')">Actualizar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL CREAR -->
<form id="formCrearIngreso">
    <div class="modal fade" id="modalCrearIngreso">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar ingreso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="limpiarCrear()"></button>
                </div>
                <div class="modal-body">
                    <label>Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required>

                    <label>Trabajador</label>
                    <input type="number" name="trabajadorid" id="trabajadorid" class="form-control" required>

                    <label>Proveedor</label>
                    <input type="number" name="proveedorid" id="proveedorid" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- MODAL ACTUALIZAR -->
<form id="formActualizarIngreso">
    <div class="modal fade" id="modalActualizarIngreso">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar ingreso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="limpiarActualizar()"></button>
                </div>
                <div class="modal-body">
                    <label>Fecha</label>
                    <input type="date" id="fechaActualizar" class="form-control">

                    <label>Trabajador</label>
                    <input type="number" id="trabajadoridActualizar" class="form-control">

                    <label>Proveedor</label>
                    <input type="number" id="proveedoridActualizar" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="<?php echo constant('URL') ?>public/js/ingresoApp.js"></script>
</body>
</html>
