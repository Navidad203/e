// Constantes para completar las rutas de la API.
const COMISION_API = 'business/dashboard/detalle_comision.php';
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
    let subtotal = 0;
    // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
    let total = 0;
    // RECORDS.textContent ='';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(COMISION_API, action, form);
    
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            subtotal = row.porcentaje * row.valor;
            total += subtotal;
            // Se establece un icono para el estado del producto.

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
        <tr>
            <td>${row.id_detalle_comision}</td>
            <td>${row.nombre_empleado}</td>
            <td>${row.nombre_servicio}</td>
            <td>${row.porcentaje}</td>
            <td>${row.total_comision}</td>
            <td>${row.valor}</td>
            <td class="align-middle">
            <p class="mb-0" style="font-weight: 500;">${subtotal.toFixed(2)}</p>
        </td>
            <td>
                    <div class="btn-group">
                        <a  class="dropdown_icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-more">
                            <li>
                                <a data-bs-toggle="modal" data-bs-target="#save-modal" onclick="updateDetalle_comision(${row.id_detalle_comision})">
                                    <i class="fa fa-pencil-square-o"></i>
                                    Editar
                                </a>
                            </li>
                            <li>
                                <a onclick="DeleteComision(${row.id_detalle_comision})">
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

function createDetallePlanilla() {
    // FORMULARIO.reset();
    TITULO_MODAL.textContent = 'CREAR DETALLE COMISION';
    fillSelect(COMISION_API, 'readServicio', 'servicio');
}


async function updateDetalle_comision(id_detalle_comision) {
// FORMULARIO.reset();
const FORM = new FormData();
FORM.append('id_detalle_comision', id_detalle_comision);
const JSON = await dataFetch(COMISION_API, 'readOne', FORM);
if (JSON.status) {
TITULO_MODAL.textContent ='MODIFICAR DETALLE';
document.getElementById('id').value = JSON.dataset.id_detalle_comision;
// fillSelect(COMISION_API, 'readEmpleado', 'empleado', JSON.dataset.id_empleado);
fillSelect(COMISION_API, 'readServicio', 'servicio', JSON.dataset.id_servicio);
document.getElementById('porcentaje').value = JSON.dataset.porcentaje;
document.getElementById('monto').value = JSON.dataset.monto;
document.getElementById('total_comision').value = JSON.dataset.total_comision;
}
}

async function DeleteComision(id_detalle_comision) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el detalle de la comision de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_detalle_comision', id_detalle_comision);
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