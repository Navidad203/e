<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detalle_planilla_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Detalle_Planilla extends DetallePlanillaQueries
{
    // Declaración de atributos (propiedades).
    protected $id_detalle_planilla = null;
    protected $id_empleado = null;
    protected $id_planilla = null;
    protected $id_detalle_comision = null;
    protected $id_usuario = null;
    protected $id_horas_extra = null;
    protected $salario_base = null;
    protected $total_descuento = null;

    /*
    *   Métodos para validar y asignar valores de los atributos. 13 campos
    */
    public function setid_detalle_planilla($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_planilla = $value;
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
    public function setid_planilla($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_planilla = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setid_detalle_comision($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_comision = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setId_usuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setid_horas_extra($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_horas_extra = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSalario_base($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->salario_base = $value;
            return true;
        } else {
            return false;
        }
    }

    public function settotal_descuento($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->total_descuento = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getid_detalle_planilla()
    {
        return $this->id_detalle_planilla;
    }

    public function getid_empleado()
    {
        return $this->id_empleado;
    }

    public function getid_planilla()
    {
        return $this->id_planilla;
    }

    public function getid_detalle_comision()
    {
        return $this->id_detalle_comision;
    }

    public function getid_usuario()
    {
        return $this->id_usuario;
    }

    public function getid_horas_extra()
    {
        return $this->id_horas_extra;
    }

    public function getsalario_base()
    {
        return $this->salario_base;
    }

    public function gettotal_descuento()
    {
        return $this->total_descuento;
    }

}
