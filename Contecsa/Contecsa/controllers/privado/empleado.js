// Constantes para completar las rutas de la API.
const EMPLEADO_API = 'business/dashboard/empleado.php';


const TITULO_MODAL = document.getElementById('modal-title');

const TBODY_ROWS = document.getElementById('tboby-row');

const FORMULARIO = document.getElementById('save-form');

const EMPLEADO = document.getElementById('empleado');

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');


// javascript se manda a llamar el id y en php el name uwu

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    CargarEmpleado();
});

SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    CargarEmpleado(FORM);
});


FORMULARIO.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(FORMULARIO);
    const JSON = await dataFetch(EMPLEADO_API, action, FORM);
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        CargarEmpleado();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


async function CargarEmpleado(form = null) {
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(EMPLEADO_API, action, form);
    if (JSON.status) {
        EMPLEADO.innerHTML = '';

        JSON.dataset.forEach((row) => {
            // este se utiliza en el bussines de EMPLEADO_API es el como un reemplazo del id de un input y
            //  con este se agarran los id del detalle para hacer el crear comentario y es una variable aparte
            EMPLEADO.innerHTML += `

                    <div class="card col-sm-18">
                        <div class="card-content">
                            <div class="image">
    
                                <img src="${SERVER_URL}images/empleado/${row.pfp}" alt="">
                            </div>
    
    
                            <div class="namw-profession">
                                <span class="name">${row.nombre_empleado}</span>
                                <span class="profession">${row.nombre_area}</span>
                            </div>
    
    
                            <div class="button">
                                <button class="editar" data-bs-toggle="modal" data-bs-target="#save-modal" onclick="updateEmpleado(${row.id_empleado})">editar</button>
                            <button class="eliminar" onclick="DeleteEmpleado(${row.id_empleado})">eliminar</button>
                            </div>
                        </div>
                    </div>
        `;
        })
    } else {
        console.log("Error al mostrar");
    }
}


/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
// */

function createEmpleado() {
    TITULO_MODAL.textContent = 'CREAR UN EMPLEADO';
    // FORMULARIO.reset();
    document.getElementById('archivo').required = true;
    //se setea una ruta predeterminada para la imagen
    document.getElementById('archivo').src = '../../api/images/empleado/';
    fillSelect(EMPLEADO_API, 'readGenero', 'genero');
    fillSelect(EMPLEADO_API, 'readArea', 'area');
    fillSelect(EMPLEADO_API, 'readCargo', 'cargo');
}

async function updateEmpleado(id_empleado) {
    // FORMULARIO.reset();
    //se pone el input de la imagen como no obligatorio
    document.getElementById('archivo').required = false;
    const FORM = new FormData();
    FORM.append('id_empleado', id_empleado);
    const JSON = await dataFetch(EMPLEADO_API, 'readOne', FORM);
    if (JSON.status) {
        TITULO_MODAL.textContent = 'MODIFICAR EMPLEADO';
        document.getElementById('id').value = JSON.dataset.id_empleado;
        document.getElementById('archivo').src = '../../api/images/empleado/' + JSON.dataset.pfp;
        document.getElementById('nombre').value = JSON.dataset.nombre_empleado;
        document.getElementById('telefono').value = JSON.dataset.telefono_empleado;
        document.getElementById('dui').value = JSON.dataset.dui;
        document.getElementById('correo').value = JSON.dataset.correo_electronico;
        document.getElementById('sueldo').value = JSON.dataset.sueldo;
        document.getElementById('isss').value = JSON.dataset.isss;
        document.getElementById('fecha_contratacion').value = JSON.dataset.fecha_contratacion;
        document.getElementById('fecha_nacimiento').value = JSON.dataset.fecha_nacimiento;
        fillSelect(EMPLEADO_API, 'readGenero', 'genero', JSON.dataset.genero);
        fillSelect(EMPLEADO_API, 'readArea', 'area', JSON.dataset.id_area);
        fillSelect(EMPLEADO_API, 'readCargo', 'cargo', JSON.dataset.id_cargo);
    }
}

async function DeleteEmpleado(id_empleado) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar un empleado  de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_empleado', id_empleado);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(EMPLEADO_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            CargarEmpleado();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}
