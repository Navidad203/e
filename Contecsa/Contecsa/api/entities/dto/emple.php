<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/emple_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Empleado extends EmpleadoQueries_
{
    // Declaración de atributos (propiedades).
    protected $id_empleado = null;
    protected $pfp = null;
    protected $nombre_empleado = null;
    protected $telefono_empleado = null;
    protected $dui = null;
    protected $correo_electronico = null;
    protected $sueldo = null;
    protected $isss = null;
    protected $fecha_contratacion = null;
    protected $fecha_nacimiento = null;
    protected $genero = null;
    protected $id_area = null;
    protected $id_cargo = null;

    protected $ruta = '../../images/empleado/';


    /*
    *   Métodos para validar y asignar valores de los atributos. 13 campos
    */

    public function setid_empleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPfp($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->pfp = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setnombre_empleado($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->nombre_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono_empleado($value)
    {
        if (Validator::validateString($value, 1, 12)) {
            $this->telefono_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setdui($value)
    {
        if (Validator::validateString($value, 1, 10)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo_electronico($value)
    {
        if (Validator::validateEmail($value, 1, 120)) {
            $this->correo_electronico = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setsueldo($value)
    {
        if (Validator::validateMoney($value)) {
            $this->sueldo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setisss($value)
    {
        if (Validator::validateString($value, 1, 120)) {
            $this->isss = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setfecha_contratacion($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_contratacion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setfecha_nacimiento($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_nacimiento = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setgenero($value)
    {
        if (Validator::validateString($value, 1, 120)) {
            $this->genero = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setid_are($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_area = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setid_cargo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cargo = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */

    public function getid_empleado()
    {
        return $this->id_empleado;
    }

    public function getpfp()
    {
        return $this->pfp;
    }

    public function getnombre_empleado()
    {
        return $this->nombre_empleado;
    }

    public function gettelefono_empleado()
    {
        return $this->telefono_empleado;
    }

    public function getdui()
    {
        return $this->dui;
    }

    public function getcorreo_electronico()
    {
        return $this->correo_electronico;
    }

    public function getsueldo()
    {
        return $this->sueldo;
    }

    public function getisss()
    {
        return $this->isss;
    }

    public function getfecha_contratacion()
    {
        return $this->fecha_contratacion;
    }

    public function getfecha_nacimiento()
    {
        return $this->fecha_nacimiento;
    }

    public function getgenero()
    {
        return $this->genero;
    }

    public function getid_area()
    {
        return $this->id_area;
    }

    public function getid_cargo()
    {
        return $this->id_cargo;
    }
    
    public function getRuta()
    {
        return $this->ruta;
    }
}
