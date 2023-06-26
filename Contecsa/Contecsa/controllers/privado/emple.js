// Constantes para completar las rutas de la API.
const EMPLEADO_API_ = 'business/dashboard/emple.php';


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
    const JSON = await dataFetch(_, action, FORM);
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
    TBODY_ROWS.innerHTML = '';
    // RECORDS.textContent ='';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(EMPLEADO_API_, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
<tr>
    <td>${row.id_empleado}</td>
    <td><img class="coverM" src="../../api/images/empleado/${row.pfp}"></td>
    <td>${row.nombre_empleado}</td>
    <td>${row.telefono_empleado}</td>
    <td>${row.dui}</td>
    <td>${row.correo_electronico}</td>

    <td>${row.isss}</td>
    <td>${row.fecha_contratacion}</td>
    <td>${row.fecha_nacimiento}</td>
    <td>${row.genero}</td>

    <td>${row.cargo}</td>
    
    
    <td>
                <div class="btn-group">
                    <a  class="dropdown_icon" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-more">
                        <li>
                            <a data-bs-toggle="modal" data-bs-target="#save-modal" onclick="updateEmpleado(${row.id_empleado})">
                                <i class="fa fa-pencil-square-o"></i>
                                Editar
                            </a>
                        </li>
                        <li>
                            <a onclick="DeleteEmpleado(${row.id_empleado})">
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



/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
// */

function createEmpleado() {
    // FORMULARIO.reset();
    TITULO_MODAL.textContent = 'CREAR UN EMPLEADO';
    fillSelect(EMPLEADO_API_, 'readGenero', 'genero');
    fillSelect(EMPLEADO_API_, 'readArea', 'area');
    fillSelect(EMPLEADO_API_, 'readCargo', 'cargo');
}

async function updateEmpleado(id_empleado) {
    // FORMULARIO.reset();
    document.getElementById('archivo').required = false;

    const FORM = new FormData();
    FORM.append('id_empleado', id_empleado);
    const JSON = await dataFetch(EMPLEADO_API_, 'readOne', FORM);
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
        fillSelect(EMPLEADO_API_, 'readGenero', 'genero', JSON.dataset.genero);
        fillSelect(EMPLEADO_API_, 'readArea', 'area', JSON.dataset.id_area);
        fillSelect(EMPLEADO_API_, 'readCargo', 'cargo', JSON.dataset.id_cargo);
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
        const JSON = await dataFetch(EMPLEADO_API_, 'delete', FORM);
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
