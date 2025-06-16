console.log("ingresoApp.js cargado correctamente");

let ingresoId = 0;
const url = window.url || "http://localhost/FERRETERIA/"; // ajustar si es necesario

document.addEventListener("DOMContentLoaded", () => {

    // Crear Ingreso
    document.getElementById("crearIngreso").addEventListener("submit", (event) => {
        event.preventDefault();

        const fecha = document.getElementById("fechaIngreso").value;
        const trabajadorId = document.getElementById("trabajadorId").value;
        const proveedorId = document.getElementById("proveedorId").value;

        if (!fecha || !trabajadorId || !proveedorId) {
            return mostrarNotificacion("Error", "Todos los campos son obligatorios", "error");
        }

        const form = new FormData();
        form.append("fecha", fecha);
        form.append("trabajadorId", trabajadorId);
        form.append("proveedorId", proveedorId);

        fetch(url + "Ingresos/Crear", {
            method: "POST",
            body: form,
        })
            .then(res => res.json())
            .then(data => {
                mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error");
                if (data.Respuesta) location.reload();
            })
            .catch(error => {
                console.error("Error al crear ingreso:", error);
            });
    });

    // Actualizar Ingreso
    document.getElementById("actualizarIngreso").addEventListener("submit", (event) => {
        event.preventDefault();

        const fecha = document.getElementById("fechaIngresoActualizar").value;
        const trabajadorId = document.getElementById("trabajadorIdActualizar").value;
        const proveedorId = document.getElementById("proveedorIdActualizar").value;

        if (!fecha || !trabajadorId || !proveedorId) {
            return mostrarNotificacion("Error", "Todos los campos son obligatorios", "error");
        }

        const form = new FormData();
        form.append("ingresoId", ingresoId);
        form.append("fecha", fecha);
        form.append("trabajadorId", trabajadorId);
        form.append("proveedorId", proveedorId);

        fetch(url + "Ingresos/Actualizar", {
            method: "POST",
            body: form,
        })
            .then(res => res.json())
            .then(data => {
                mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error");
                if (data.Respuesta) location.reload();
            })
            .catch(error => {
                console.error("Error al actualizar ingreso:", error);
            });
    });

});

function cargarIngreso(id, fecha, trabajadorId, proveedorId) {
    ingresoId = id;
    document.getElementById("fechaIngresoActualizar").value = fecha;
    document.getElementById("trabajadorIdActualizar").value = trabajadorId;
    document.getElementById("proveedorIdActualizar").value = proveedorId;
}

function eliminarIngreso(id) {
    Swal.fire({
        title: "¿Eliminar ingreso?",
        text: "No se puede revertir.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            const form = new FormData();
            form.append("ingresoId", id);

            fetch(url + "Ingresos/Eliminar", {
                method: "POST",
                body: form,
            })
                .then(res => res.json())
                .then(data => {
                    mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? "success" : "error");
                    if (data.Respuesta) location.reload();
                })
                .catch(error => {
                    console.error("Error al eliminar ingreso:", error);
                });
        }
    });
}

function mostrarNotificacion(titulo, mensaje, icono) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: icono,
        confirmButtonText: "OK",
    });
}

function limpiarCrear() {
    document.getElementById("fechaIngreso").value = "";
    document.getElementById("trabajadorId").value = "";
    document.getElementById("proveedorId").value = "";
}

function limpiarActualizar() {
    document.getElementById("fechaIngresoActualizar").value = "";
    document.getElementById("trabajadorIdActualizar").value = "";
    document.getElementById("proveedorIdActualizar").value = "";
}
