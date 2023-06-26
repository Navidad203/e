// Constantes para completar las rutas de la API.
const DETALLE_API = 'business/dashboard/detalle_planilla.php';
// const CATEGORIA_API = 'business/dashboard/categoria.php';
const TITULO_MODAL = document.getElementById('modal-title');
const TITULO_MODAL_PLANILLA = document.getElementById('Planilla_modal1');
const TITULO_MODAL_DETALLE = document.getElementById('Detalle_comision1');

const TBODY_ROWS = document.getElementById('tboby-row');
const TBODY_ROWS_PLANILLA = document.getElementById('tboby-row-planilla');
const TBODY_ROWS_DETALLE = document.getElementById('tboby-row-detalle');
// const TBODY_ROWS = document.getElementById('tboby-row');

const FORMULARIO= document.getElementById('save-form');
const FORMULARIO_PLANILLA = document.getElementById('save-form-planilla');
const FORMULARIO_DETALLE = document.getElementById('save-form-detalle');
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
    const JSON = await dataFetch(DETALLE_API, action, FORM);
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


FORMULARIO_PLANILLA.addEventListener('submit', async(event) =>{
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(FORMULARIO_PLANILLA);
    const JSON = await dataFetch(DETALLE_API, action, FORM);
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTablePlanilla();      
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


FORMULARIO_DETALLE.addEventListener('submit', async(event) =>{
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(FORMULARIO_DETALLE);
    const JSON = await dataFetch(DETALLE_API, action, FORM);
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTableDetalle();      
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
    // RECORDS.textContent ='';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(DETALLE_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
            <td>${row.id_detalle_planilla}</td>
            <td>${row.nombre_empleado}</td>
            <td>
                <div class="btn-group">
                    <a  class="dropdown-toggle dropdown_icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a data-bs-toggle="modal" data-bs-target="#Planilla_modal" onclick="fillTablePlanilla(${row.id_detalle_planilla})">
                                planilla
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="btn-group">
                    <a  class="dropdown-toggle dropdown_icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a data-bs-toggle="modal" data-bs-target="#Detalle_comision" onclick="fillTableDetalle(${row.id_detalle_planilla})">
                                Detalle Comision
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
            <td>${row.nombre_usuario}</td>
            <td>${row.valor}</td>
            <td>${row.salario_base}</td>
            <td>${row.total_descuento}</td>
            <td>
                <div class="btn-group">
                    <a  class="dropdown-toggle dropdown_icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-more">
                        <li>
                            <a data-bs-toggle="modal" data-bs-target="#save-modal" onclick="updateDetalle_planilla(${row.id_detalle_planilla})">
                                <i class="fa fa-pencil-square-o"></i>
                                Editar
                            </a>
                        </li>
                        <li>
                            <a onclick="DeletePlanilla(${row.id_detalle_planilla})">
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
    TITULO_MODAL.textContent = 'CREAR DETALLE PLANILLA';
    fillSelect(DETALLE_API, 'readPlanilla', 'planilla'); 
    fillSelect(DETALLE_API, 'readComision', 'comision'); 
    fillSelect(DETALLE_API, 'readUsuario', 'usuario'); 
    fillSelect(DETALLE_API, 'readHoras_extra', 'horas_extra'); 

}

function createPlanilla() {
    // FORMULARIO.reset();
    TITULO_MODAL_PLANILLA.textContent = 'CREAR PLANILLA';   
    fillTablePlanilla();
}

function createDetalleComision() {
    // FORMULARIO.reset();
    TITULO_MODAL_DETALLE.textContent = 'CREAR DETALLE COMISION';
    fillTableDetalle();

}

async function updateDetalle_planilla(id_detalle_planilla) {
    // FORMULARIO.reset();
    const FORM = new FormData();
    FORM.append('id_detalle_planilla', id_detalle_planilla);
    const JSON = await dataFetch(DETALLE_API, 'readOne', FORM);
    if (JSON.status) {
        TITULO_MODAL.textContent ='MODIFICAR PRODUCTO';
        document.getElementById('id').value = JSON.dataset.id_detalle_planilla;
        fillSelect(DETALLE_API, 'readPlanilla', 'planilla', JSON.dataset.id_planilla);
        fillSelect(DETALLE_API, 'readComision', 'comision', JSON.dataset.id_detalle_comision);
        fillSelect(DETALLE_API, 'readUsuario', 'usuario', JSON.dataset.id_usuario);
        fillSelect(DETALLE_API, 'readHoras_extra', 'horas_extra', JSON.dataset.id_horas_extra);
        document.getElementById('salario').value = JSON.dataset.salario_base;
        document.getElementById('descuento').value = JSON.dataset.total_descuento;
    }
}

async function DeletePlanilla(id_detalle_planilla) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el detalle de la planilla de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_detalle_planilla', id_detalle_planilla);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(DETALLE_API, 'delete', FORM);
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



async function fillTablePlanilla(id_detalle_planilla) {
    // Se inicializa el contenido de la tabla.
    TITULO_MODAL_PLANILLA.textContent = 'DETALLE PLANILLA';

    TBODY_ROWS_PLANILLA.innerHTML = '';
    // RECORDS_DETALLE.textContent = '';
    // Se verifica la acción a realizar.
    const FORM = new FormData();
    FORM.append('id_detalle_planilla', id_detalle_planilla);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(DETALLE_API, 'readAllPlanilla', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            // (row.estado_detalle_pedido) ? icon = 'visibility' : icon = 'visibility_off';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_PLANILLA.innerHTML += `
            <tr>
                <th scope="row">${row.id_planilla}</th>
                <td>${row.dias_trabajados}</td>
                <td>${row.fecha_inicio}</td>
                <td>${row.fecha_fin}</td>
                <td>${row.estado_planilla}</td>
            </tr>
            `;
        });

        // RECORDS_DETALLE.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}


async function fillTableDetalle(id_detalle_planilla) {
    // Se inicializa el contenido de la tabla.
    TITULO_MODAL_DETALLE.textContent = 'DETALLE COMISION';

    TBODY_ROWS_DETALLE.innerHTML = '';
    // RECORDS_DETALLE.textContent = '';
    // Se verifica la acción a realizar.
    const FORM = new FormData();
    FORM.append('id_detalle_planilla', id_detalle_planilla);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(DETALLE_API, 'readAllDetalle', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            // (row.estado_detalle_pedido) ? icon = 'visibility' : icon = 'visibility_off';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_DETALLE.innerHTML += `
            <tr>
                <th scope="row">${row.id_detalle_comision}</th>
                <td>${row.nombre_empleado}</td>
                <td>${row.nombre_servicio}</td>
                <td>${row.porcentaje}</td>
                <td>${row.monto}</td>
            </tr>
            `;
        });

        // RECORDS_DETALLE.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}