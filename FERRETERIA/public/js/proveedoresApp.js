console.log("proveedoresApp.js cargado correctamente");

let proveedorId = null;

// Validaciones al cargar
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("crearProveedor").addEventListener("submit", (event) => {
        event.preventDefault();
        const nombre = document.getElementById("razonSocial").value.trim();
        const regex = /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,-]+$/;

        if (!regex.test(nombre)) {
            mostrarNotificacion("Validación", "❌ Nombre inválido: Solo letras, números y espacios", "error", "OK");
            return;
        }

        const formData = new FormData();
        formData.append("razonSocial", nombre);

        fetch(url + "Proveedores/Crear", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error", "OK");
            if (data.Respuesta) {
                agregarFila(data.Valor, nombre);
                LimpiarCrear();
            }
        })
        .catch(error => console.error("Error al guardar:", error));
    });

    document.getElementById("actualizarProveedor").addEventListener("submit", (event) => {
        event.preventDefault();
        const nombre = document.getElementById("razonSocialActualizar").value.trim();
        const regex = /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,-]+$/;

        if (!regex.test(nombre)) {
            mostrarNotificacion("Validación", "❌ Nombre inválido: Solo letras, números y espacios", "error", "OK");
            return;
        }

        const formData = new FormData();
        formData.append("proveedorId", proveedorId);
        formData.append("razonSocial", nombre);

        fetch(url + "Proveedores/Actualizar", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error", "OK");
            if (data.Respuesta) actualizarFila(proveedorId, nombre);
        })
        .catch(error => console.error("Error al actualizar:", error));
    });
});

function mostrarNotificacion(titulo, cuerpo, icono, boton) {
    Swal.fire({ title: titulo, html: cuerpo, icon: icono, confirmButtonText: boton });
}

function Eliminar(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append("proveedorId", id);

            fetch(url + "Proveedores/Eliminar", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error", "OK");
                if (data.Respuesta) eliminarFila(id);
            })
            .catch(error => console.error("Error al eliminar:", error));
        }
    });
}

function Actualizar(id, nombre) {
    proveedorId = id;
    document.getElementById("razonSocialActualizar").value = nombre;
}

function agregarFila(id, nombre) {
    const tr = document.createElement("tr");
    tr.setAttribute("model-target", id);

    const tdId = document.createElement("td");
    tdId.textContent = id;

    const tdNombre = document.createElement("td");
    tdNombre.textContent = nombre;

    const tdAcciones = document.createElement("td");

    const btnEliminar = document.createElement("button");
    btnEliminar.className = "btn btn-danger btn-sm";
    btnEliminar.textContent = "Eliminar";
    btnEliminar.onclick = () => Eliminar(id);

    const btnActualizar = document.createElement("button");
    btnActualizar.className = "btn btn-primary btn-sm";
    btnActualizar.setAttribute("data-bs-toggle", "modal");
    btnActualizar.setAttribute("data-bs-target", "#modalActualizar");
    btnActualizar.textContent = "Actualizar";
    btnActualizar.onclick = () => Actualizar(id, nombre);

    tdAcciones.appendChild(btnEliminar);
    tdAcciones.appendChild(btnActualizar);

    tr.appendChild(tdId);
    tr.appendChild(tdNombre);
    tr.appendChild(tdAcciones);

    document.getElementById("CuerpoTabla").appendChild(tr);
}

function actualizarFila(id, nombre) {
    const fila = document.querySelector(`tr[model-target="${id}"]`);
    if (fila) {
        fila.children[1].textContent = nombre;
        const btnActualizar = fila.querySelector(".btn-primary");
        if (btnActualizar) {
            btnActualizar.onclick = () => Actualizar(id, nombre);
        }
    }
}

function eliminarFila(id) {
    const fila = document.querySelector(`tr[model-target="${id}"]`);
    if (fila) fila.remove();
}

function LimpiarCrear() {
    document.getElementById("razonSocial").value = "";
}

function LimpiarActualizar() {
    document.getElementById("razonSocialActualizar").value = "";
}
