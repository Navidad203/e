<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad AREA.
*/
class AreaQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_area, nombre_area
        FROM area
        WHERE nombre_area ILIKE ? OR nombre_area ILIKE ?
        ORDER BY nombre_area';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO area(nombre_area)
                VALUES(?)';
        $params = array($this->nombre);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_area, nombre_area
                FROM area
                ORDER BY nombre_area';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_area, nombre_area
                FROM area
                WHERE id_area = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE area
                SET nombre_area = ?
                WHERE id_area = ?';
        $params = array($this->nombre, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM area
                WHERE id_area = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
