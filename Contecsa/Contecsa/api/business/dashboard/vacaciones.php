<?php
require_once('../../entities/dto/vacaciones.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $Vacaciones = new Vacaciones;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $Vacaciones->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $Vacaciones->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$Vacaciones->setfecha_inicio($_POST['fecha_inicio'])) {
                    $result['exception'] = 'salario incorrecto';
                } elseif (!$Vacaciones->setfecha_fin($_POST['fecha_fin'])) {
                    $result['exception'] = 'salario incorrecto';
                } elseif (!$Vacaciones->setanticipo($_POST['anticipo'])) {
                    $result['exception'] = 'descuento incorrecto';
                } elseif (!isset($_POST['empleado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$Vacaciones->setid_empleado($_POST['empleado'])) {
                    $result['exception'] = 'empleado incorrecta';
                } elseif ($Vacaciones->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha creado correctamente';
                }  else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$Vacaciones->setid_vaciones($_POST['id_vaciones'])) {
                    $result['exception'] = 'Vacaciones incorrecto';
                } elseif ($result['dataset'] = $Vacaciones->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Vacacion inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$Vacaciones->setid_vaciones($_POST['id'])) {
                    $result['exception'] = 'id incorrecto';
                }elseif (!$data = $Vacaciones->readOne()) {
                    $result['exception'] = 'id inexistente';
                } elseif (!$Vacaciones->setfecha_inicio($_POST['fecha_inicio'])) {
                    $result['exception'] = 'salario incorrecto';
                } elseif (!$Vacaciones->setfecha_fin($_POST['fecha_fin'])) {
                    $result['exception'] = 'salario incorrecto';
                } elseif (!$Vacaciones->setanticipo($_POST['anticipo'])) {
                    $result['exception'] = 'descuento incorrecto';
                } elseif (!isset($_POST['empleado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$Vacaciones->setid_empleado($_POST['empleado'])) {
                    $result['exception'] = 'empleado incorrecta';
                } elseif ($Vacaciones->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$Vacaciones->setid_vaciones($_POST['id_vaciones'])) {
                    $result['exception'] = 'comision incorrecta';
                } elseif (!$data = $Vacaciones->readOne()) {
                    $result['exception'] = 'comision inexistente';
                } elseif ($Vacaciones->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'comision eliminado correctamente';
                } else{ 
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readEmpleado':
                if ($result['dataset'] = $Vacaciones->readEmpleado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            // case 'readServicio':
            //     if ($result['dataset'] = $Vacaciones->readServicio()) {
            //         $result['status'] = 1;
            //         $result['message'] = 'Existen registros';
            //     } elseif (Database::getException()) {
            //         $result['exception'] = Database::getException();
            //     } else {
            //         $result['exception'] = 'No hay datos registrados';
            //     }
            //     break;
            case 'porcentajeProductosCategoria':
                if ($result['dataset'] = $producto->porcentajeProductosCategoria()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
