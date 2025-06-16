const url = window.urlBase || ""; // usa constante definida en tu layout si aplica
let productoId = 0;

document.addEventListener("DOMContentLoaded", () => {

    // Crear producto
    document.getElementById("crearProducto").addEventListener("submit", function (e) {
        e.preventDefault();
        const form = new FormData(this);

        fetch(url + "Productos/Crear", {
            method: "POST",
            body: form
        })
            .then(res => res.json())
            .then(data => {
                Swal.fire("Aviso", data.Mensaje, data.Respuesta ? "success" : "error");
                if (data.Respuesta) location.reload();
            });
    });

    // Actualizar producto
    document.getElementById("actualizarProducto").addEventListener("submit", function (e) {
        e.preventDefault();
        const form = new FormData(this);
        form.append("productoId", productoId);

        fetch(url + "Productos/Actualizar", {
            method: "POST",
            body: form
        })
            .then(res => res.json())
            .then(data => {
                Swal.fire("Aviso", data.Mensaje, data.Respuesta ? "success" : "error");
                if (data.Respuesta) location.reload();
            });
    });
});

// Eliminar producto
function eliminarProducto(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            const form = new FormData();
            form.append("productoId", id);

            fetch(url + "Productos/Eliminar", {
                method: "POST",
                body: form
            })
                .then(res => res.json())
                .then(data => {
                    Swal.fire("Aviso", data.Mensaje, data.Respuesta ? "success" : "error");
                    if (data.Respuesta) location.reload();
                });
        }
    });
}

// Cargar datos en modal actualizar
function cargarProducto(id, codigo, nombre, descripcion, proveedorId) {
    productoId = id;
    document.getElementById("codigoActualizar").value = codigo;
    document.getElementById("nombreActualizar").value = nombre;
    document.getElementById("descripcionActualizar").value = descripcion;
    document.getElementById("proveedorIdActualizar").value = proveedorId;
}
