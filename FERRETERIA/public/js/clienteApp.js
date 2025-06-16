// clienteApp.js corregido con "clienteid" en minúsculas
console.log("clienteApp.js cargado correctamente");

let clienteId;

// Asignar evento al cargar el documento
window.addEventListener("DOMContentLoaded", () => {
    // Evento crear cliente
    document.getElementById("crearCliente").addEventListener("submit", (event) => {
        event.preventDefault();
        const nombre = document.getElementById("nombreCliente").value.trim();
        if (nombre === "") return mostrar("Error", "El nombre no puede estar vacío", "error");

        const form = new FormData();
        form.append("nombreCliente", nombre);

        fetch(url + "Clientes/Crear", {
            method: "POST",
            body: form
        })
            .then(res => res.json())
            .then(data => {
                mostrar("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error');
                if (data.Respuesta) location.reload();
            })
            .catch(error => {
                console.error("Error al crear cliente:", error);
                mostrar("Error", "No se pudo crear el cliente", "error");
            });
    });

    // Evento actualizar cliente
    document.getElementById("actualizarCliente").addEventListener("submit", (event) => {
        event.preventDefault();
        const nombre = document.getElementById("nombreClienteActualizar").value.trim();
        if (nombre === "") return mostrar("Error", "El nombre no puede estar vacío", "error");

        const form = new FormData();
        form.append("clienteid", clienteId); // CORREGIDO
        form.append("nombreCliente", nombre);

        fetch(url + "Clientes/Actualizar", {
            method: "POST",
            body: form
        })
            .then(res => res.json())
            .then(data => {
                mostrar("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error');
                if (data.Respuesta) location.reload();
            })
            .catch(error => {
                console.error("Error al actualizar cliente:", error);
                mostrar("Error", "No se pudo actualizar el cliente", "error");
            });
    });
});

function cargarCliente(id, nombre) {
    clienteId = id;
    document.getElementById("nombreClienteActualizar").value = nombre;
}

function eliminarCliente(id) {
    Swal.fire({
        title: "¿Eliminar cliente?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            const form = new FormData();
            form.append("clienteid", id); // CORREGIDO

            fetch(url + "Clientes/Eliminar", {
                method: "POST",
                body: form
            })
                .then(res => res.json())
                .then(data => {
                    mostrar("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error');
                    if (data.Respuesta) location.reload();
                })
                .catch(error => {
                    console.error("Error al eliminar cliente:", error);
                    mostrar("Error", "No se pudo eliminar el cliente", "error");
                });
        }
    });
}

function mostrar(titulo, cuerpo, icono) {
    Swal.fire({
        title: titulo,
        text: cuerpo,
        icon: icono,
        confirmButtonText: "OK"
    });
}

function limpiarCrear() {
    document.getElementById("nombreCliente").value = "";
}

function limpiarActualizar() {
    document.getElementById("nombreClienteActualizar").value = "";
}