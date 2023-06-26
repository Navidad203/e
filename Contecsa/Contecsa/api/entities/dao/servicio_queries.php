<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad SERVICIO.
*/
class ServicioQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_servicio, servicio.nombre_servicio, servicio.descripcion_servicio, servicio.valor, servicio.fecha_inicio, servicio.fecha_fin, servicio.id_empleado, empleado.nombre_empleado, servicio.estado_servicio, servicio.tipo_servicio
        FROM servicio
        INNER JOIN empleado USING (id_empleado)
        WHERE nombre_servicio ILIKE ? OR descripcion_servicio ILIKE ? OR nombre_empleado ILIKE ?
        ORDER BY nombre_servicio';
        $params = array("%$value%", "%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO servicio(nombre_servicio, descripcion_servicio, valor, fecha_inicio, fecha_fin, id_empleado, estado_servicio, tipo_servicio)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->valor, $this->fechaInicio, $this->fechaFin, $this->idEmpleado, $this->estado, $this->tipo);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_servicio, servicio.nombre_servicio, servicio.descripcion_servicio, servicio.valor, servicio.fecha_inicio, servicio.fecha_fin, servicio.id_empleado, empleado.nombre_empleado, servicio.estado_servicio, servicio.tipo_servicio
        FROM servicio
		INNER JOIN empleado USING (id_empleado)';
        return Database::getRows($sql);
    }

    public function readEmpleado()
    {
        $sql = 'SELECT id_empleado, nombre_empleado FROM empleado';
        return Database::getRows($sql);
    }
    
    public function readOne()
    {
        $sql = 'SELECT id_servicio, nombre_servicio, descripcion_servicio, valor, fecha_inicio, fecha_fin, id_empleado, estado_servicio, tipo_servicio
                FROM servicio
                WHERE id_servicio = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE servicio
                SET nombre_servicio = ?, descripcion_servicio = ?, valor = ?, fecha_inicio = ?, fecha_fin = ?, id_empleado = ?, estado_servicio = ?, tipo_servicio = ?
                WHERE id_servicio= ?';
        $params = array($this->nombre, $this->descripcion, $this->valor, $this->fechaInicio, $this->fechaFin, $this->idEmpleado, $this->estado, $this->tipo ,$this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM servicio
                WHERE id_servicio = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
