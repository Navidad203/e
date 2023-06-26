// Constantes para completar las rutas de la API.
const COMISION_API = 'business/dashboard/vacaciones.php';
// const CATEGORIA_API = 'business/dashboard/categoria.php';
const TITULO_MODAL = document.getElementById('modal-title');

const TBODY_ROWS = document.getElementById('tboby-row');

const FORMULARIO = document.getElementById('save-form');

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');


// javascript se manda a llamar el id y en php el name uwu

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

SEARCH_FORM.addEventListener('submit', (event) => {
// Se evita recargar la página web después de enviar el formulario.
event.preventDefault();
// Constante tipo objeto con los datos del formulario.
const FORM = new FormData(SEARCH_FORM);
// Llamada a la función para llenar la tabla con los resultados de la búsqueda.
fillTable(FORM);
});


FORMULARIO.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(FORMULARIO);
    const JSON = await dataFetch(COMISION_API, action, FORM);
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
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    // RECORDS.textContent ='';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(COMISION_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
<tr>
    <td>${row.id_vaciones}</td>
    <td>${row.fecha_inicio}</td>
    <td>${row.fecha_fin}</td>
    <td>${row.anticipo}</td>
    <td>${row.nombre_empleado}</td>
    <td>
                <div class="btn-group">
                    <a  class="dropdown_icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-more">
                        <li>
                            <a data-bs-toggle="modal" data-bs-target="#save-modal" onclick="updateDetalle_comision(${row.id_vaciones})">
                                <i class="fa fa-pencil-square-o"></i>
                                Editar
                            </a>
                        </li>
                        <li>
                            <a onclick="DeleteComision(${row.id_vaciones})">
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

        // RECORDS.textContent = JSON.message;

    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

function createVacaciones() {
    // FORMULARIO.reset();
    TITULO_MODAL.textContent = 'CREAR VACACIONES';
    fillSelect(COMISION_API, 'readEmpleado', 'empleado');
}

async function updateDetalle_comision(id_vaciones) {
    // FORMULARIO.reset();
    const FORM = new FormData();
    FORM.append('id_vaciones', id_vaciones);
    const JSON = await dataFetch(COMISION_API, 'readOne', FORM);
    if (JSON.status) {
        TITULO_MODAL.textContent = 'MODIFICAR DETALLE';
        document.getElementById('id').value = JSON.dataset.id_vaciones;
        document.getElementById('fecha_inicio').value = JSON.dataset.fecha_inicio;
        document.getElementById('fecha_fin').value = JSON.dataset.fecha_fin;
        document.getElementById('anticipo').value = JSON.dataset.anticipo;
        fillSelect(COMISION_API, 'readEmpleado', 'empleado', JSON.dataset.id_empleado);
    }
}

async function DeleteComision(id_vaciones) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el detalle de la comision de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_vaciones', id_vaciones);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(COMISION_API, 'delete', FORM);
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