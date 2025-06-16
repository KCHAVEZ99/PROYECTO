<?php
// Este archivo debe estar en views/Productos/index.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .btn-sm { margin-right: 5px; }
        img { object-fit: cover; }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Gestión de Productos</h2>
    <div class="text-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrear">Nuevo Producto</button>
    </div>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
        <tr>
            <th>Imagen</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Proveedor</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->model as $producto): ?>
            <tr>
                <td><img src="<?php echo constant('URL') . 'public/img/productos/' . $producto['imagen']; ?>" width="60" height="60"></td>
                <td><?= $producto['codigo'] ?></td>
                <td><?= $producto['nombre'] ?></td>
                <td><?= $producto['descripcion'] ?></td>
                <td><?= $producto['proveedorId'] ?></td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="eliminarProducto(<?= $producto['id'] ?>)">Eliminar</button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalActualizar"
                            onclick="cargarProducto(<?= $producto['id'] ?>, '<?= $producto['codigo'] ?>', '<?= $producto['nombre'] ?>', '<?= $producto['descripcion'] ?>', <?= $producto['proveedorId'] ?>)">
                        Actualizar
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Crear -->
<form id="crearProducto" enctype="multipart/form-data">
    <div class="modal fade" id="modalCrear">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="codigo" placeholder="Código" class="form-control mb-2" required>
                    <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-2" required>
                    <input type="text" name="descripcion" placeholder="Descripción" class="form-control mb-2" required>
                    <input type="file" name="imagen" class="form-control mb-2" required>
                    <select name="proveedorId" class="form-control" required>
                        <option value="">Seleccione proveedor</option>
                        <?php foreach ($this->proveedores as $proveedor): ?>
                            <option value="<?= $proveedor['id'] ?>"><?= $proveedor['razonSocial'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal Actualizar -->
<form id="actualizarProducto" enctype="multipart/form-data">
    <div class="modal fade" id="modalActualizar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="productoIdActualizar">
                    <input type="text" id="codigoActualizar" name="codigo" class="form-control mb-2" required>
                    <input type="text" id="nombreActualizar" name="nombre" class="form-control mb-2" required>
                    <input type="text" id="descripcionActualizar" name="descripcion" class="form-control mb-2" required>
                    <input type="file" name="imagen" class="form-control mb-2">
                    <select id="proveedorIdActualizar" name="proveedorId" class="form-control" required>
                        <option value="">Seleccione proveedor</option>
                        <?php foreach ($this->proveedores as $proveedor): ?>
                            <option value="<?= $proveedor['id'] ?>"><?= $proveedor['razonSocial'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    const url = "<?php echo constant('URL') ?>";
    let productoId = 0;

    document.getElementById("crearProducto").addEventListener("submit", function(e) {
        e.preventDefault();
        const form = new FormData(this);
        fetch(url + "Productos/Crear", { method: "POST", body: form })
            .then(res => res.json())
            .then(data => {
                Swal.fire("Aviso", data.Mensaje, data.Respuesta ? "success" : "error");
                if (data.Respuesta) location.reload();
            });
    });

    document.getElementById("actualizarProducto").addEventListener("submit", function(e) {
        e.preventDefault();
        const form = new FormData(this);
        form.append("productoId", productoId);
        fetch(url + "Productos/Actualizar", { method: "POST", body: form })
            .then(res => res.json())
            .then(data => {
                Swal.fire("Aviso", data.Mensaje, data.Respuesta ? "success" : "error");
                if (data.Respuesta) location.reload();
            });
    });

    function eliminarProducto(id) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar"
        }).then(result => {
            if (result.isConfirmed) {
                const form = new FormData();
                form.append("productoId", id);
                fetch(url + "Productos/Eliminar", { method: "POST", body: form })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire("Aviso", data.Mensaje, data.Respuesta ? "success" : "error");
                        if (data.Respuesta) location.reload();
                    });
            }
        });
    }

    function cargarProducto(id, codigo, nombre, descripcion, proveedorId) {
        productoId = id;
        document.getElementById("codigoActualizar").value = codigo;
        document.getElementById("nombreActualizar").value = nombre;
        document.getElementById("descripcionActualizar").value = descripcion;
        document.getElementById("proveedorIdActualizar").value = proveedorId;
    }
</script>
</body>
</html>
