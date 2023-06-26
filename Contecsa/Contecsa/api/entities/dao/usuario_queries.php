<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */
    public function checkUser($nombre)
    {
        $sql = 'SELECT id_usuario FROM usuario WHERE correo_electronico = ?';
        $params = array($nombre);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_usuario = $data['id_usuario'];
            $this->correo_electronico = $nombre;
            return true;
        } else {
            return false;
        }
    }

    public function searchRows($value)
    {
        $sql = 'SELECT u.id_usuario, u.nombre, t.tipo_documento, u.numero_doc, u.telefono, u.correo_electronico, u.direccion , u.clave, e.estado
        FROM usuarios u
		INNER JOIN tipos_documentos t on u.id_tipodoc = t.id_tipodoc
		INNER JOIN estados_usuarios e on u.id_estadousuario = e.id_estadousuario		
        WHERE nombre ILIKE ? OR correo_electronico ILIKE ?
        ORDER BY nombre';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }


    public function readtipo_doc(){
        $sql = 'SELECT id_tipodoc, tipo_documento FROM tipos_documentos';
        return Database::getRows($sql);
    }

    public function readestado_usuario(){
        $sql = 'SELECT id_estadousuario, estado FROM estados_usuarios';
        return Database::getRows($sql);
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave FROM usuario WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        $data= Database::getRow($sql,$params);
        if ($password==$data['clave']) {
        return true;
        }else{
        return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuario SET clave = ? WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_electronico, clave, telefono, fecha_nacimiento
        FROM usuario
        WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombre = ?, telefono = ?, correo_electronico = ?, direccion = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre, $this->telefono, $this->correo_electronico, $this->direccion, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    /*
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE apellidos_usuario ILIKE ? OR nombres_usuario ILIKE ?
                ORDER BY apellidos_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    */

    public function createRow()
    {
        $sql = 'INSERT INTO usuarios (nombre, id_tipodoc, numero_doc, telefono, correo_electronico, direccion, clave, id_estadousuario)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->id_tipodoc, $this->num_doc, $this->telefono, $this->correo_electronico, $this->direccion, $this->clave, $this->id_estado_usuario);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios SET nombre = ?, id_tipodoc = ?, numero_doc = ?, telefono = ?, correo_electronico = ?, direccion = ?, clave = ?, id_estadousuario = ? WHERE id_usuario = ? ';
        $params = array($this->nombre, $this->id_tipodoc, $this->num_doc, $this->telefono, $this->correo_electronico, $this->direccion, $this->clave, $this->id_estado_usuario, $this->id_usuario);
        return Database::executeRow($sql, $params);
    }

public function readAll(){
    $sql = 'SELECT u.id_usuario, u.nombre, t.tipo_documento, u.numero_doc, u.telefono, u.correo_electronico, u.direccion , u.clave, e.estado
    FROM usuarios u
    INNER JOIN tipos_documentos t on u.id_tipodoc = t.id_tipodoc
    INNER JOIN estados_usuarios e on u.id_estadousuario = e.id_estadousuario
    ORDER BY id_usuario';
    return Database::getRows($sql);
}



public function readOne()
{
    $sql = 'SELECT * FROM usuario
            WHERE id_usuario = ?';
    $params = array($this->id_usuario);
    return Database::getRow($sql, $params);
}

 
public function deleteRow()
{
    $sql = 'DELETE FROM usuarios
            WHERE id_usuario = ?';
    $params = array($this->id_usuario);
    return Database::executeRow($sql, $params);
}
}
