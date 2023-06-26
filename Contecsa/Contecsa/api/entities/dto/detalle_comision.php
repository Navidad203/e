<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detalle_comision_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Detalle_comision extends DetallecomisionQueries
{
    // Declaración de atributos (propiedades).
    protected $id_detalle_comision = null;
    protected $id_servicio = null;
    protected $porcentaje = null;
    protected $monto = null;
    protected $total_comision = null;

    /*
    *   Métodos para validar y asignar valores de los atributos. 13 campos
    */
    public function setid_detalle_comision($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_comision = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setid_servicio($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_servicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setporcentaje($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->porcentaje = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setmonto($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->monto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function settotal_comision($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->total_comision = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getid_detalle_comision()
    {
        return $this->id_detalle_comision;
    }

    public function gettotal_comision()
    {
        return $this->total_comision;
    }

    public function getid_servicio()
    {
        return $this->id_servicio;
    }

    public function getporcentaje()
    {
        return $this->porcentaje;
    }

    public function getmonto()
    {
        return $this->monto;
    }
}
