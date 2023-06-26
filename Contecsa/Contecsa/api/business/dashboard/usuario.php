<?php
require_once('../../entities/dto/usuario.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null, 'id' => 0);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['correo_electronico'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['correo_electronico'];
                    $result['id'] = $_SESSION ['id_usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;

            case 'readProfile':
                if ($result['dataset'] = $usuario->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->editProfile()) {
                    $result['status'] = 1;
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                } elseif (!$usuario->setClave($_POST['nueva'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // accion 
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // accion para buscar datos en la tabla 
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                // acccion para cargar combo box de tipo de usuarios 
                case 'readtipo_doc':
                    if ($result['dataset'] = $usuario->readtipo_doc()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen registros';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
                    // accion para combo box 
                case 'readestado_usuario':
                    if ($result['dataset'] = $usuario->readestado_usuario()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen registros';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
                    // accion para crear nuevos usuarios 
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!isset($_POST['documento'])) {
                    $result['exception'] = 'Seleccione un documento';
                } elseif (!$usuario->setid_tipo_doc($_POST['documento'])) {
                    $result['exception'] = 'tipo de documento incorrecta';
                } elseif (!$usuario->setNumero_doc($_POST['num_doc'])) {
                    $result['exception'] = 'numero documento incorrecto';
                } elseif (!$usuario->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'numero de telefono incorrecto';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif (!$usuario->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecto';
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = 'clave incorrecto';
                } elseif (!isset($_POST['estado_usuario'])) {
                    $result['exception'] = 'Seleccione un documento';
                } elseif (!$usuario->setid_estado_usuario($_POST['estado_usuario'])) {
                    $result['exception'] = 'tipo de documento incorrecta';
                }  elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // accion para leer los id 
            case 'readOne':
                if (!$usuario->setid_usuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
                // acccion para actualizar 
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setid_usuario($_POST['id'])) {
                    $result['exception'] = 'id incorrecto';
                } elseif (!$data = $usuario->readOne()) {
                    $result['exception'] = 'id inexistente';
                } elseif (!$usuario->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!isset($_POST['documento'])) {
                    $result['exception'] = 'Seleccione una documento';
                } elseif (!$usuario->setid_tipo_doc($_POST['documento'])) {
                    $result['exception'] = 'Documento incorrecta';
                } elseif (!$usuario->setNumero_doc($_POST['num_doc'])) {
                    $result['exception'] = 'numero de documento incorrecto';
                } elseif (!$usuario->setTelefono(isset($_POST['telefono']) ? 1 : 0)) {
                    $result['exception'] = 'telefono incorrecto';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif (!$usuario->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecto';
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = 'stock incorrecto';
                } elseif (!isset($_POST['estado_usuario'])) {
                    $result['exception'] = 'Seleccione una documento';
                } elseif (!$usuario->setid_estado_usuario($_POST['estado_usuario'])) {
                    $result['exception'] = 'Documento incorrecta';
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$usuario->setid_usuario($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($_POST['codigo'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setClave($_POST['codigo'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // acccion para que deje al login con el correo y clave del la tabla usuarios 
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->checkUser($_POST['correo_electronico'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticacion correcta';
                    $_SESSION['id_usuario'] = $usuario->getId_usuario();
                    $_SESSION['correo_electronico'] = $usuario->getCorreo();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
