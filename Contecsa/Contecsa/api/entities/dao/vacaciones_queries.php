<?php
require_once('../../helpers/database.php');

// clases en PHP inicial mayuscula cada palabra su nombre es StudlyCaps

/*funcion para leer datos*/
class VacacionesQueries
{
    // consulta para que me cargue todos los datos de la tabla producto y lo ocupar en sitio privado 
    public function readAll()
    {
        $sql = 'SELECT  id_vaciones, empleado.nombre_empleado, vacaciones.fecha_inicio, vacaciones.fecha_fin, vacaciones.anticipo, empleado.id_empleado
        FROM vacaciones   
        INNER JOIN empleado USING(id_empleado)';
        return Database::getRows($sql);
    }

    // public function readAllServicio()
    // {
    //     $sql = 'SELECT  id_detalle_comision, empleado.nombre_empleado, servicio.nombre_servicio, detalle_comision.porcentaje, detalle_comision.monto
    //     FROM detalle_comision   
    //     INNER JOIN empleado USING(id_empleado) 
	// 	INNER JOIN servicio USING(id_servicio)';
    //     return Database::getRows($sql);
    // }

//    otro estandar es que las variables van en minuscula como por ejemplo $sql,$params
// consulta para los bucadores segun el nombre del producto este se ocupa en el sitio privado
// estandar de programacion que se aplica camelCase 
    public function searchRows($value)
    {
        $sql = 'SELECT  id_vaciones, empleado.nombre_empleado, vacaciones.fecha_inicio, vacaciones.fecha_fin, vacaciones.anticipo, empleado.id_empleado
        FROM vacaciones
        INNER JOIN empleado USING(id_empleado)
        WHERE nombre_empleado ILIKE ? OR anticipo ILIKE ?
        ORDER BY nombre_empleado';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    /*funcion para eliminar datos*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM vacaciones
                WHERE id_vaciones = ?';
        $params = array($this->id_vaciones);
        return Database::executeRow($sql, $params);
    }

    /*funcion para leer datos*/
    public function readOne()
    {
        $sql = 'SELECT * FROM vacaciones
                WHERE id_vaciones = ?';
        $params = array($this->id_vaciones);
        return Database::getRow($sql, $params);
    }

    /*cargar combox */

    public function readEmpleado()
    {
        $sql = 'SELECT id_empleado, nombre_empleado FROM empleado';
        return Database::getRows($sql);
    }

    /*funcion para crear insercion*/

    public function createRow()
    {
        $sql = 'INSERT INTO vacaciones(fecha_inicio, fecha_fin, anticipo, id_empleado) 
        VALUES(?, ?, ?, ?)';
        $params = array($this->fecha_inicio, $this->fecha_fin, $this->anticipo, $this->id_empleado,);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE vacaciones SET fecha_inicio = ?, fecha_fin = ?, anticipo = ?, id_empleado = ? WHERE id_vaciones = ? ';
        $params = array($this->fecha_inicio, $this->fecha_fin, $this->anticipo, $this->id_empleado, $this->id_vaciones);
        return Database::executeRow($sql, $params);
    }
  
}
