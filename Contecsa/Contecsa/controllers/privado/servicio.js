// Constante para completar la ruta de la API.
const SERVICIO_API = 'business/dashboard/servicio.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(SERVICIO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();

        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    // RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(SERVICIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
            <td>${row.id_servicio}</td>
            <td>${row.nombre_servicio}</td>
            <td>${row.descripcion_servicio}</td>
            <td>${row.valor}</td>
            <td>${row.fecha_inicio}</td>
            <td>${row.fecha_fin}</td>
            <td>${row.nombre_empleado}</td>
            <td>${row.estado_servicio}</td>
            <td>${row.tipo_servicio}</td>
            <td>
                        <div class="btn-group">
                            <a  class="dropdown_icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-more">
                                <li>
                                    <a data-bs-toggle="modal" data-bs-target="#save-modal" onclick="openUpdate(${row.id_servicio})">
                                        <i class="fa fa-pencil-square-o"></i>
                                        Editar
                                    </a>
                                </li>
                                <li>
                                    <a onclick="openDelete(${row.id_servicio})">
                                        <i class="fa fa-trash"></i>
                                        Eliminar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            `;
        });
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function openCreate() {
    MODAL_TITLE.textContent = 'Agregar un servicio';
    fillSelect(SERVICIO_API, 'readEmpleado', 'empleado');
    fillSelect(SERVICIO_API, 'readEstadoServicio', 'estado');
    fillSelect(SERVICIO_API, 'readTipoServicio', 'tipo');

}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id_servicio) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_servicio', id_servicio);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(SERVICIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
       MODAL_TITLE.textContent = 'Actualizar servicio';

        document.getElementById('id').value = JSON.dataset.id_servicio;
        document.getElementById('nombre').value = JSON.dataset.nombre_servicio;
        document.getElementById('descripcion').value = JSON.dataset.descripcion_servicio;
        document.getElementById('valor').value = JSON.dataset.valor;
        document.getElementById('fecha_inicio').value = JSON.dataset.fecha_inicio;
        document.getElementById('fecha_fin').value = JSON.dataset.fecha_fin;
        fillSelect(SERVICIO_API, 'readEmpleado', 'empleado', JSON.dataset.id_empleado);
        fillSelect(SERVICIO_API, 'readEstadoServicio', 'estado', JSON.dataset.estado_servicio);
        fillSelect(SERVICIO_API, 'readTipoServicio', 'tipo', JSON.dataset.tipo_servicio);

    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id_servicio) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el servicio de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_servicio', id_servicio);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(SERVICIO_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}
