<?php
require_once('../../entities/dto/cargo.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cargo = new Cargo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $cargo->readAll()) {
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
                } elseif ($result['dataset'] = $cargo->searchRows($_POST['search'])) {
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
                if (!$cargo->setNombre($_POST['nombre_cargo'])) {
                    $result['exception'] = 'Nombre incorrecto';
                }elseif ($cargo->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Se ha creado correctamente';
                    }  else {
                        $result['exception'] = Database::getException();
                    }
                break;
            case 'readOne':
                if (!$cargo->setId($_POST['id_cargo'])) {
                    $result['exception'] = 'Cargo incorrecto';
                } elseif ($result['dataset'] = $cargo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cargo inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$cargo->setId($_POST['id'])) {
                    $result['exception'] = 'id incorrecto';
                }elseif (!$data = $cargo->readOne()) {
                    $result['exception'] = 'id inexistente';
                } elseif (!$cargo->setNombre($_POST['nombre_cargo'])) {
                    $result['exception'] = 'nombre del cargo incorrecto';
                } elseif ($cargo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$cargo->setId($_POST['id_cargo'])) {
                    $result['exception'] = 'cargo incorrecta';
                } elseif (!$data = $cargo->readOne()) {
                    $result['exception'] = 'cargo inexistente';
                } elseif ($cargo->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'cargo eliminado correctamente';
                } else{ 
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
