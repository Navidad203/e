<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/servicio_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad SERVICIO.
*/
class Servicio extends ServicioQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $valor = null;
    protected $fechaInicio = null;
    protected $fechaFin = null;
    protected $idEmpleado = null;
    protected $estado = null;
    protected $tipo = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 150)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setValor($value)
    {
        if (Validator::validateMoney($value)) {
            $this->valor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaInicio($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaInicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaFin($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaFin = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idEmpleado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipo($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    public function getIdEmpleado()
    {
        return $this->idEmpleado;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getTipo()
    {
        return $this->tipo;
    }
}
