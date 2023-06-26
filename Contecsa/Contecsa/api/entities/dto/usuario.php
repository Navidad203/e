<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Usuario extends UsuarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id_usuario = null;
    protected $nombre = null;
    protected $id_tipodoc = null;
    protected $num_doc = null;
    protected $telefono = null;
    protected $correo_electronico = null;
    protected $direccion = null;
    protected $clave = null;
    protected $id_estado_usuario = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setid_usuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setid_estado_usuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_estado_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setid_tipo_doc($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_tipodoc = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNumero_doc($value)
    {
        if (Validator::validateString($value, 1, 15)) {
            $this->num_doc = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validateString($value, 1, 9)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value, 1, 120)) {
           $this->correo_electronico = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->direccion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validateString($value, 1, 120)) {
            $this->clave = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function getid_tipo_doc()
    {
        return $this->id_tipodoc;
    }

    public function getnumero_doc()
    {
        return $this->num_doc;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getCorreo()
    {
        return $this->correo_electronico;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getid_estado_usuario()
    {
        return $this->clave;
    }
}