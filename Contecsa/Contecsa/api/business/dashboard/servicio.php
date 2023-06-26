<?php
require_once('../../entities/dto/servicio.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $servicio = new Servicio;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $servicio->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
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
                } elseif ($result['dataset'] = $servicio->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$servicio->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$servicio->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripcion incorrecto';
                } elseif (!$servicio->setValor($_POST['valor'])) {
                    $result['exception'] = 'valor incorrecto';
                } elseif (!$servicio->setFechaInicio($_POST['fecha_inicio'])) {
                    $result['exception'] = 'fecha incorrecto';
                }elseif (!$servicio->setFechaFin($_POST['fecha_fin'])) {
                    $result['exception'] = 'fecha fin incorrecto';
                } elseif (!isset($_POST['empleado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$servicio->setIdEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'empleado incorrecta';
                }elseif (!isset($_POST['estado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$servicio->setEstado($_POST['estado'])) {
                    $result['exception'] = 'estado incorrecta';
                }elseif (!isset($_POST['tipo'])) {
                    $result['exception'] = 'Seleccione un tipo';
                } elseif (!$servicio->setTipo($_POST['tipo'])) {
                    $result['exception'] = 'tipo incorrecta';
                } elseif ($servicio->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha creado correctamente';
                }  else {
                    $result['exception'] = Database::getException();;
                }
                break;
            case 'readOne':
                if (!$servicio->setId($_POST['id_servicio'])) {
                    $result['exception'] = 'Servicio incorrecto';
                } elseif ($result['dataset'] = $servicio->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Servicio inexistente';
                }
                break;
            case 'readEmpleado':
                if ($result['dataset'] = $servicio->readEmpleado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readEstadoServicio':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Finalizado', 'Finalizado'),
                    array('En curso', 'En curso'),
                    array('Pausado', 'Pausado')
                );
                break;
            case 'readTipoServicio':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('vendedor', 'vendedor'),
                    array('ingeniero en sistemas', 'ingeniero en sistemas')
                );
                break;
                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$servicio->setId($_POST['id'])) {
                        $result['exception'] = 'Servicio incorrecto';
                    } elseif (!$data = $servicio->readOne()) {
                        $result['exception'] = 'Servicio inexistente';
                    } elseif (!$servicio->setNombre($_POST['nombre'])) {
                        $result['exception'] = 'Nombre incorrecto';
                    } elseif (!$servicio->setDescripcion($_POST['descripcion'])) {
                        $result['exception'] = 'Descripcion incorrecto';
                    } elseif (!$servicio->setValor($_POST['valor'])) {
                        $result['exception'] = 'valor incorrecto';
                    } elseif (!$servicio->setFechaInicio($_POST['fecha_inicio'])) {
                        $result['exception'] = 'fecha incorrecto';
                    }elseif (!$servicio->setFechaFin($_POST['fecha_fin'])) {
                        $result['exception'] = 'fecha fin incorrecto';
                    } elseif (!isset($_POST['empleado'])) {
                        $result['exception'] = 'Seleccione un empleado';
                    } elseif (!$servicio->setIdEmpleado($_POST['empleado'])) {
                        $result['exception'] = 'empleado incorrecta';
                    }elseif (!isset($_POST['estado'])) {
                        $result['exception'] = 'Seleccione un empleado';
                    } elseif (!$servicio->setEstado($_POST['estado'])) {
                        $result['exception'] = 'estado incorrecta';
                    }elseif (!isset($_POST['tipo'])) {
                        $result['exception'] = 'Seleccione un tipo';
                    } elseif (!$servicio->setTipo($_POST['tipo'])) {
                        $result['exception'] = 'tipo incorrecta';
                    }  elseif ($servicio->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Se ha actualizado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                case 'delete':
                    if (!$servicio->setId($_POST['id_servicio'])) {
                        $result['exception'] = 'Servicio incorrecto';
                    } elseif (!$data = $servicio->readOne()) {
                        $result['exception'] = 'Servicio inexistente';
                    } elseif ($servicio->deleteRow()) {
                        $result['status'] = 1;
                        {
                            $result['message'] = 'Servicio eliminado correctamente';
                        }
                    } else {
                        $result['exception'] = Database::getException();
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
