<?php
require_once('../../entities/dto/detalle_comision.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $Detalle_C = new Detalle_comision;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $Detalle_C->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // case 'readAllServicio':
                //     if (!$Detalle_C->setid_detalle_comision($_POST['id_detalle_comision'])) {
                //         $result['exception'] = 'planilla incorrecto';
                //     } elseif ($result['dataset'] = $Detalle_C->readAllServicio()) {
                //         $result['status'] = 1;
                //         $result['message'] = 'Existen '.count($result['dataset']).' registros';
                //     } elseif (Database::getException()) {
                //         $result['exception'] = Database::getException();
                //     } else {
                //         $result['exception'] = 'No hay datos registrados';
                //     } 
                //     break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $Detalle_C->searchRows($_POST['search'])) {
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
                if (!isset($_POST['servicio'])) {
                    $result['exception'] = 'Seleccione un servicio';
                } elseif (!$Detalle_C->setid_servicio($_POST['servicio'])) {
                    $result['exception'] = 'servicio incorrecta';
                } elseif (!$Detalle_C->setporcentaje($_POST['porcentaje'])) {
                    $result['exception'] = 'salario incorrecto';
                } elseif (!$Detalle_C->setmonto($_POST['monto'])) {
                    $result['exception'] = 'descuento incorrecto';
                } elseif (!$Detalle_C->settotal_comision($_POST['total_comision'])) {
                    $result['exception'] = 'total_comision incorrecto';
                } elseif ($Detalle_C->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha creado correctamente';
                }  else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$Detalle_C->setid_detalle_comision($_POST['id_detalle_comision'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $Detalle_C->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$Detalle_C->setid_detalle_comision($_POST['id'])) {
                    $result['exception'] = 'id incorrecto';
                }elseif (!$data = $Detalle_C->readOne()) {
                    $result['exception'] = 'id inexistente';
                }elseif (!isset($_POST['servicio'])) {
                    $result['exception'] = 'Seleccione un servicio';
                } elseif (!$Detalle_C->setid_servicio($_POST['servicio'])) {
                    $result['exception'] = 'servicio incorrecta';
                } elseif (!$Detalle_C->setporcentaje($_POST['porcentaje'])) {
                    $result['exception'] = 'salario incorrecto';
                } elseif (!$Detalle_C->setmonto($_POST['monto'])) {
                    $result['exception'] = 'descuento incorrecto';
                } elseif (!$Detalle_C->settotal_comision($_POST['total_comision'])) {
                    $result['exception'] = 'total_comision incorrecto';
                } elseif ($Detalle_C->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$Detalle_C->setid_detalle_comision($_POST['id_detalle_comision'])) {
                    $result['exception'] = 'comision incorrecta';
                } elseif (!$data = $Detalle_C->readOne()) {
                    $result['exception'] = 'comision inexistente';
                } elseif ($Detalle_C->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'comision eliminado correctamente';
                } else{ 
                    $result['exception'] = Database::getException();
                }
                break;
            // case 'readEmpleado':
            //     if ($result['dataset'] = $Detalle_C->readEmpleado()) {
            //         $result['status'] = 1;
            //         $result['message'] = 'Existen registros';
            //     } elseif (Database::getException()) {
            //         $result['exception'] = Database::getException();
            //     } else {
            //         $result['exception'] = 'No hay datos registrados';
            //     }
            //     break;
            case 'readServicio':
                if ($result['dataset'] = $Detalle_C->readServicio()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            // case 'porcentajeProductosCategoria':
            //     if ($result['dataset'] = $producto->porcentajeProductosCategoria()) {
            //         $result['status'] = 1;
            //     } else {
            //         $result['exception'] = 'No hay datos disponibles';
            //     }
            //     break;
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
