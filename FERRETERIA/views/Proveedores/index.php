<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Proveedores</title>

    <!-- CSS & JS externos -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilos propios -->
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/estilosGenerales.css">
    <style>
        .btn-sm {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Gestión de Proveedores</h2>

        <!-- Botón -->
        <div class="mb-3 text-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrear">Nuevo proveedor</button>
        </div>

        <!-- Tabla -->
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Razón Social</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="CuerpoTabla">
                <?php foreach ($this->model as $proveedor): ?>
                    <tr model-target="<?= $proveedor['proveedorId'] ?>">
                        <td><?= $proveedor['proveedorId'] ?></td>
                        <td><?= $proveedor['razonSocial'] ?></td>
                        <td><?= $proveedor['direccion'] ?></td>
                        <td><?= $proveedor['telefono'] ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="eliminarProveedor(<?= $proveedor['proveedorId'] ?>)">Eliminar</button>
                            <button class="btn btn-primary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#modalActualizar"
                                onclick="cargarProveedor(<?= $proveedor['proveedorId'] ?>, '<?= $proveedor['razonSocial'] ?>', '<?= $proveedor['direccion'] ?>', '<?= $proveedor['telefono'] ?>')">
                                Actualizar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Crear -->
    <form id="crearProveedor">
        <div class="modal fade" id="modalCrear" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="limpiarCrear()"></button>
                    </div>
                    <div class="modal-body">
                        <label for="razonSocial">Razón Social</label>
                        <input type="text" class="form-control mb-2" id="razonSocial" name="razonSocial" required>

                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control mb-2" id="direccion" name="direccion" required>

                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarCrear()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal Actualizar -->
    <form id="actualizarProveedor">
        <div class="modal fade" id="modalActualizar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualizar Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="limpiarActualizar()"></button>
                    </div>
                    <div class="modal-body">
                        <label for="razonSocialActualizar">Razón Social</label>
                        <input type="text" class="form-control mb-2" id="razonSocialActualizar" name="razonSocial" required>

                        <label for="direccionActualizar">Dirección</label>
                        <input type="text" class="form-control mb-2" id="direccionActualizar" name="direccion" required>

                        <label for="telefonoActualizar">Teléfono</label>
                        <input type="text" class="form-control" id="telefonoActualizar" name="telefono" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarActualizar()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- JS Funcionalidad -->
    <script>
        const url = "<?php echo constant('URL') ?>";

        let proveedorId;

        function eliminarProveedor(id) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "No se podrá revertir esta acción.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = new FormData();
                    form.append("proveedorId", id);
                    fetch(url + "Proveedores/Eliminar", { method: "POST", body: form })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error");
                            if (data.Respuesta) location.reload();
                        });
                }
            });
        }

        function cargarProveedor(id, razon, direccion, telefono) {
            proveedorId = id;
            document.getElementById("razonSocialActualizar").value = razon;
            document.getElementById("direccionActualizar").value = direccion;
            document.getElementById("telefonoActualizar").value = telefono;
        }

        document.getElementById("crearProveedor").addEventListener("submit", function(e) {
            e.preventDefault();
            const form = new FormData(this);
            fetch(url + "Proveedores/Crear", { method: "POST", body: form })
                .then(res => res.json())
                .then(data => {
                    Swal.fire("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error");
                    if (data.Respuesta) location.reload();
                });
        });

        document.getElementById("actualizarProveedor").addEventListener("submit", function(e) {
            e.preventDefault();
            const form = new FormData();
            form.append("proveedorId", proveedorId);
            form.append("razonSocial", document.getElementById("razonSocialActualizar").value);
            form.append("direccion", document.getElementById("direccionActualizar").value);
            form.append("telefono", document.getElementById("telefonoActualizar").value);
            fetch(url + "Proveedores/Actualizar", { method: "POST", body: form })
                .then(res => res.json())
                .then(data => {
                    Swal.fire("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error");
                    if (data.Respuesta) location.reload();
                });
        });

        function limpiarCrear() {
            document.getElementById("razonSocial").value = "";
            document.getElementById("direccion").value = "";
            document.getElementById("telefono").value = "";
        }

        function limpiarActualizar() {
            document.getElementById("razonSocialActualizar").value = "";
            document.getElementById("direccionActualizar").value = "";
            document.getElementById("telefonoActualizar").value = "";
        }
    </script>
</body>
</html>
