console.log("categoriaApp.js cargado correctamente");

var categoriaid;
var nombreCategoria;

document.addEventListener("DOMContentLoaded", function () {

    // CREAR CATEGORIA
    document.getElementById("crearCategoria").addEventListener("submit", function (event) {
        event.preventDefault();
        var categoria = document.getElementById("nombreCategoria");
        var mensajes = [];
        var resultado = true;
        const regexNombre = /^[a-zA-Z\s]+$/;

        if (regexNombre.test(categoria.value.trim())) {
            mensajes.push('✔ Nombre válido');
        } else {
            mensajes.push('❌ El nombre solo debe contener letras y espacios');
            resultado = false;
        }

        var listaMensajes = '<ul style="text-align: left;">';
        mensajes.forEach(function (mensaje) {
            listaMensajes += '<li>' + mensaje + '</li>';
        });
        listaMensajes += '</ul>';

        if (resultado) {
            enviarFormulario();
        } else {
            mostrarNotificacion('Validación de Datos', listaMensajes, 'error', 'OK');
        }
    });

    // ACTUALIZAR CATEGORIA
    document.getElementById("actualizarCategoria").addEventListener("submit", function (event) {
        event.preventDefault();
        var categoriaActualizar = document.getElementById("nombreCategoriaActualizar");
        var mensajes = [];
        var resultado = true;
        const regexNombre = /^[a-zA-Z\s]+$/;

        if (regexNombre.test(categoriaActualizar.value.trim())) {
            mensajes.push('✔ Nombre válido');
        } else {
            mensajes.push('❌ El nombre solo debe contener letras y espacios');
            resultado = false;
        }

        var listaMensajes = '<ul style="text-align: left;">';
        mensajes.forEach(function (mensaje) {
            listaMensajes += '<li>' + mensaje + '</li>';
        });
        listaMensajes += '</ul>';

        if (resultado) {
            ActualizarCategoria(categoriaid, categoriaActualizar.value.trim());
        } else {
            mostrarNotificacion('Validación de Datos', listaMensajes, 'error', 'OK');
        }
    });
});

function mostrarNotificacion(titulo, cuerpo, icono, boton) {
    Swal.fire({
        title: titulo,
        html: cuerpo,
        icon: icono,
        confirmButtonText: boton
    });
}

function enviarFormulario() {
    const formulario = document.getElementById("crearCategoria");
    const formData = new FormData(formulario);
    const nombreCategoria = formData.get("nombreCategoria").trim();

    fetch(url + "Categorias/Crear", {
        method: "POST",
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error', 'OK');
            if (data.Respuesta) {
                AgregarFila(data.Valor, nombreCategoria);
                LimpiarCrear();
            }
        })
        .catch(error => {
            console.error("Error al enviar el formulario:", error);
            alert("Error al enviar el formulario.");
        });
}

function Eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas eliminar esta categoría?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            const formulario = new FormData();
            formulario.append('categoriaid', id);

            fetch(url + "Categorias/Eliminar", {
                method: "POST",
                body: formulario,
            })
                .then(response => response.json())
                .then(data => {
                    mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error', 'OK');
                    if (data.Respuesta) EliminarFila(id);
                })
                .catch(error => {
                    console.error(error);
                    alert("Error al eliminar.");
                });
        }
    });
}

function EliminarFila(id) {
    const fila = document.querySelector('tr[model-target="' + id + '"]');
    if (fila) fila.remove();
}

function AgregarFila(id, nombre) {
    const nuevoTr = document.createElement('tr');
    nuevoTr.setAttribute('model-target', id);

    const tdNombre = document.createElement('td');
    tdNombre.textContent = nombre;

    const tdAcciones = document.createElement('td');

    const btnEliminar = document.createElement('button');
    btnEliminar.type = "button";
    btnEliminar.className = "btn btn-danger";
    btnEliminar.textContent = "Eliminar";
    btnEliminar.onclick = () => Eliminar(id);

    const btnActualizar = document.createElement('button');
    btnActualizar.type = "button";
    btnActualizar.className = "btn btn-primary";
    btnActualizar.textContent = "Actualizar";
    btnActualizar.setAttribute("data-bs-toggle", "modal");
    btnActualizar.setAttribute("data-bs-target", "#ModalActualizar");
    btnActualizar.onclick = () => Actualizar(id, nombre);

    tdAcciones.appendChild(btnEliminar);
    tdAcciones.appendChild(btnActualizar);

    nuevoTr.appendChild(tdNombre);
    nuevoTr.appendChild(tdAcciones);

    document.getElementById("CuerpoTabla").appendChild(nuevoTr);
}

function Actualizar(id, nombre) {
    categoriaid = id;
    document.getElementById("nombreCategoriaActualizar").value = nombre;
}

function ActualizarCategoria(id, nombre) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas actualizar esta categoría?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append("categoriaid", id);
            formData.append("nombreCategoria", nombre);

            fetch(url + "Categorias/Actualizar", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    mostrarNotificacion("Respuesta", data.Mensaje, data.Respuesta ? 'success' : 'error', 'OK');
                    if (data.Respuesta) actualizarFila(id, nombre);
                })
                .catch(error => {
                    console.error("Error al actualizar:", error);
                    alert("Error al actualizar la categoría.");
                });
        }
    });
}

function actualizarFila(id, nombre) {
    const fila = document.querySelector('tr[model-target="' + id + '"]');
    if (fila) {
        fila.cells[0].textContent = nombre;
        const btnActualizar = fila.querySelector('button.btn-primary');
        if (btnActualizar) {
            btnActualizar.onclick = () => Actualizar(id, nombre);
        }
    }
}

function LimpiarCrear() {
    document.getElementById("nombreCategoria").value = "";
}

function LimpiarActualizar() {
    document.getElementById("nombreCategoriaActualizar").value = "";
}

