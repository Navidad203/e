<?php
require_once('../../entities/dto/emple.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $Empleado_p = new Empleado;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $Empleado_p->readAll()) {
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
                    } elseif ($result['dataset'] = $Empleado_p->searchRows($_POST['search'])) {
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
                if (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$Empleado_p->setPfp($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$Empleado_p->setnombre_empleado($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecta';
                } elseif (!$Empleado_p->setTelefono_empleado($_POST['telefono'])) {
                    $result['exception'] = 'telefono incorrecto';
                } elseif (!$Empleado_p->setdui($_POST['dui'])) {
                    $result['exception'] = 'Dui incorrecto';
                } elseif (!$Empleado_p->setCorreo_electronico($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif (!$Empleado_p->setsueldo($_POST['sueldo'])) {
                    $result['exception'] = 'sueldo incorrecto';
                }elseif (!$Empleado_p->setisss($_POST['isss'])) {
                    $result['exception'] = 'ISSS incorrecto';
                } elseif (!$Empleado_p->setfecha_contratacion($_POST['fecha_contratacion'])) {
                    $result['exception'] = 'fecha_contratacion incorrecto';
                } elseif (!$Empleado_p->setfecha_nacimiento($_POST['fecha_nacimiento'])) {
                    $result['exception'] = 'fecha nacimiento incorrecto';
                }  elseif (!isset($_POST['genero'])) {
                    $result['exception'] = 'Seleccione un genero';
                } elseif (!$Empleado_p->setgenero($_POST['genero'])) {
                    $result['exception'] = 'genero incorrecta';
                } elseif (!isset($_POST['area'])) {
                    $result['exception'] = 'Seleccione un area';
                } elseif (!$Empleado_p->setid_are($_POST['area'])) {
                    $result['exception'] = 'Area incorrecta';
                } elseif (!isset($_POST['cargo'])) {
                    $result['exception'] = 'Seleccione una cargo';
                } elseif (!$Empleado_p->setid_cargo($_POST['cargo'])) {
                    $result['exception'] = 'editorial incorrecta';
                }  elseif ($Empleado_p->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $Empleado_p->getRuta(), $Empleado_p->getpfp())) {
                        $result['message'] = 'Empleado creado correctamente';
                    } else {
                        $result['message'] = 'Empleado creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$Empleado_p->setid_empleado($_POST['id_empleado'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $Empleado_p->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$Empleado_p->setid_empleado($_POST['id'])) {
                        $result['exception'] = 'id incorrecto';
                    }elseif (!$data = $Empleado_p->readOne()) {
                        $result['exception'] = 'id inexistente';
                    }if (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                        $result['exception'] = 'Seleccione una imagen';
                    } elseif (!$Empleado_p->setPfp($_FILES['archivo'])) {
                        $result['exception'] = Validator::getFileError();
                    } elseif (!$Empleado_p->setnombre_empleado($_POST['nombre'])) {
                        $result['exception'] = 'Nombre incorrecta';
                    } elseif (!$Empleado_p->setTelefono_empleado($_POST['telefono'])) {
                        $result['exception'] = 'telefono incorrecto';
                    } elseif (!$Empleado_p->setdui($_POST['dui'])) {
                        $result['exception'] = 'Dui incorrecto';
                    } elseif (!$Empleado_p->setCorreo_electronico($_POST['correo'])) {
                        $result['exception'] = 'correo incorrecto';
                    } elseif (!$Empleado_p->setsueldo($_POST['sueldo'])) {
                        $result['exception'] = 'sueldo incorrecto';
                    }elseif (!$Empleado_p->setisss($_POST['isss'])) {
                        $result['exception'] = 'ISSS incorrecto';
                    } elseif (!$Empleado_p->setfecha_contratacion($_POST['fecha_contratacion'])) {
                        $result['exception'] = 'fecha_contratacion incorrecto';
                    } elseif (!$Empleado_p->setfecha_nacimiento($_POST['fecha_nacimiento'])) {
                        $result['exception'] = 'fecha nacimiento incorrecto';
                    }  elseif (!isset($_POST['genero'])) {
                        $result['exception'] = 'Seleccione un genero';
                    } elseif (!$Empleado_p->setgenero($_POST['genero'])) {
                        $result['exception'] = 'genero incorrecta';
                    } elseif (!isset($_POST['area'])) {
                        $result['exception'] = 'Seleccione un area';
                    } elseif (!$Empleado_p->setid_are($_POST['area'])) {
                        $result['exception'] = 'Area incorrecta';
                    } elseif (!isset($_POST['cargo'])) {
                        $result['exception'] = 'Seleccione una cargo';
                    } elseif (!$Empleado_p->setid_cargo($_POST['cargo'])) {
                        $result['exception'] = 'cargo incorrecta';
                    }  elseif ($Empleado_p->updateRow()) {
                        $result['status'] = 1;
                        if (Validator::saveFile($_FILES['archivo'], $Empleado_p->getRuta(), $Empleado_p->getpfp())) {
                            $result['message'] = 'Se ha actualizado correctamente';
                        } else {
                            $result['message'] = 'Se ha actualizado, pero no se guardó la imagen';
                        }
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
            case 'delete':
                if (!$Empleado_p->setid_empleado($_POST['id_empleado'])) {
                    $result['exception'] = 'Empleado incorrecta';
                } elseif (!$data = $Empleado_p->readOne()) {
                    $result['exception'] = 'Empleado inexistente';
                } elseif ($Empleado_p->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'readArea':
                    if ($result['dataset'] = $Empleado_p->readArea()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen registros';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
                case 'readGenero':
                    $result ['status'] = 1;
                    $result ['dataset'] = array(
                        array('Masculino','Masculino'),
                        array('Femenino','Femenino')
                    );
                    break;
                case 'readCargo':
                    if ($result['dataset'] = $Empleado_p->readCargo()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen registros';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
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
