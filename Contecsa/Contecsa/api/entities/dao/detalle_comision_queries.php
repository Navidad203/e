<?php
require_once('../../helpers/database.php');

// clases en PHP inicial mayuscula cada palabra su nombre es StudlyCaps

/*funcion para leer datos*/
class DetalleComisionQueries
{
    // consulta para que me cargue todos los datos de la tabla producto y lo ocupar en sitio privado 
    public function readAll()
    {
        $sql = 'SELECT id_detalle_comision, empleado.nombre_empleado, servicio.nombre_servicio, detalle_comision.porcentaje, detalle_comision.monto, servicio.valor, detalle_comision.total_comision
        FROM detalle_comision   
		INNER JOIN servicio USING(id_servicio)
		INNER JOIN empleado USING(id_empleado)';
        return Database::getRows($sql);
    }

    public function readAllServicio()
    {
        $sql = 'SELECT  id_detalle_comision, empleado.nombre_empleado, servicio.nombre_servicio, detalle_comision.porcentaje, detalle_comision.monto
        FROM detalle_comision   
        INNER JOIN empleado USING(id_empleado) 
		INNER JOIN servicio USING(id_servicio)';
        return Database::getRows($sql);
    }

//    otro estandar es que las variables van en minuscula como por ejemplo $sql,$params
// consulta para los bucadores segun el nombre del producto este se ocupa en el sitio privado
// estandar de programacion que se aplica camelCase 
    public function searchRows($value)
    {
        $sql = 'SELECT id_detalle_comision, empleado.nombre_empleado, servicio.nombre_servicio, detalle_comision.porcentaje, detalle_comision.monto, servicio.valor, detalle_comision.total_comision
        FROM detalle_comision
        INNER JOIN servicio USING(id_servicio)
		INNER JOIN empleado USING(id_empleado)
        WHERE nombre_empleado ILIKE ? OR nombre_servicio ILIKE ?
        ORDER BY nombre_empleado';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    /*funcion para eliminar datos*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM detalle_comision
                WHERE id_detalle_comision = ?';
        $params = array($this->id_detalle_comision);
        return Database::executeRow($sql, $params);
    }

    /*funcion para leer datos*/
    public function readOne()
    {
        $sql = 'SELECT * FROM detalle_comision
                WHERE id_detalle_comision = ?';
        $params = array($this->id_detalle_comision);
        return Database::getRow($sql, $params);
    }


    public function readServicio()
    {
        $sql = 'SELECT id_servicio, nombre_servicio FROM servicio';
        return Database::getRows($sql);
    }

    /*funcion para crear insercion*/

    public function createRow()
    {
        $sql = 'INSERT INTO detalle_comision(id_servicio, porcentaje, monto, total_comision) 
        VALUES(?, ?, ?, ?)';
        $params = array($this->id_servicio, $this->porcentaje, $this->monto, $this->total_comision);
        return Database::executeRow($sql, $params);
    }
    
    public function updateRow()
    {
        $sql = 'UPDATE detalle_comision SET  id_servicio = ?, porcentaje = ?, monto = ?, total_comision = ? WHERE id_detalle_comision = ? ';
        $params = array($this->id_servicio, $this->porcentaje, $this->monto, $this -> total_comision, $this->id_detalle_comision);
        return Database::executeRow($sql, $params);
    }

}
