<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/vacaciones_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Vacaciones extends VacacionesQueries
{
    // Declaración de atributos (propiedades).
    protected $id_vaciones = null;
    protected $fecha_inicio = null;
    protected $fecha_fin = null;
    protected $anticipo = null;
    protected $id_empleado = null;


    /*
    *   Métodos para validar y asignar valores de los atributos. 13 campos
    */
    public function setid_vaciones($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_vaciones = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setid_empleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_empleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setfecha_inicio($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_inicio = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setfecha_fin($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_fin = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setanticipo($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->anticipo = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getid_vaciones()
    {
        return $this->id_vaciones;
    }

    public function getid_empleado()
    {
        return $this->id_empleado;
    }

    public function getfecha_inicio()
    {
        return $this->fecha_inicio;
    }

    public function getfecha_fin()
    {
        return $this->fecha_fin;
    }

    public function getanticipo()
    {
        return $this->anticipo;
    }
}
