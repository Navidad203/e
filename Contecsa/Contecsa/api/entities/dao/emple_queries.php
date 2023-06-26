<?php
require_once('../../helpers/database.php');

// clases en PHP inicial mayuscula cada palabra su nombre es StudlyCaps

/*funcion para leer datos*/
class EmpleadoQueries_

{
    // consulta para que me cargue todos los datos de la tabla producto y lo ocupar en sitio privado 
    public function readAll()
    {
        $sql = 'SELECT id_empleado, empleado.pfp, empleado.nombre_empleado, empleado.telefono_empleado, empleado.dui, empleado.correo_electronico, empleado.sueldo, empleado.isss, empleado.fecha_contratacion, empleado.fecha_nacimiento, empleado.genero, area.nombre_area, cargo.cargo
        FROM empleado   
        INNER JOIN area USING(id_area) 
		INNER JOIN cargo USING(id_cargo)';
        return Database::getRows($sql);
    }

    public function readAllDetalle(){
        $sql = 'SELECT id_detalle_planilla, detalle_comision.id_detalle_comision,empleado.id_empleado, empleado.nombre_empleado, servicio.nombre_servicio, detalle_comision.porcentaje, detalle_comision.monto
        FROM detalle_planilla 
		INNER JOIN empleado USING (id_empleado)
        INNER JOIN detalle_comision USING (id_detalle_comision)
		INNER JOIN servicio USING (id_servicio)
        WHERE id_detalle_planilla = ?';
        $params = array($this->id_detalle_planilla);
        return Database::getRows($sql,$params);
    }

//    otro estandar es que las variables van en minuscula como por ejemplo $sql,$params
// consulta para los bucadores segun el nombre del producto este se ocupa en el sitio privado
// estandar de programacion que se aplica camelCase 
    public function searchRows($value)
    {
        $sql = 'SELECT id_empleado, empleado.pfp, empleado.nombre_empleado, empleado.telefono_empleado, empleado.dui, empleado.correo_electronico, empleado.sueldo, empleado.isss, empleado.fecha_contratacion, empleado.fecha_nacimiento, empleado.genero, area.nombre_area, cargo.cargo
        FROM empleado
        INNER JOIN area USING(id_area) 
		INNER JOIN cargo USING(id_cargo)
        WHERE nombre_empleado ILIKE ? OR correo_electronico ILIKE ?
        ORDER BY nombre_empleado';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    /*funcion para eliminar datos*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM empleado
                WHERE id_empleado = ?';
        $params = array($this->id_empleado);
        return Database::executeRow($sql, $params);
    }

    /*funcion para leer datos*/
    public function readOne()
    {
        $sql = 'SELECT * FROM empleado
                WHERE id_empleado = ?';
        $params = array($this->id_empleado);
        return Database::getRow($sql, $params);
    }

    /*cargar combox */

    public function readArea()
    {
        $sql = 'SELECT id_area, nombre_area FROM area';
        return Database::getRows($sql);
    }

    public function readCargo()
    {
        $sql = 'SELECT id_cargo, cargo FROM cargo';
        return Database::getRows($sql);
    }

    /*funcion para crear insercion*/

    public function createRow()
    {
        $sql = 'INSERT INTO empleado(pfp, nombre_empleado, telefono_empleado, dui, correo_electronico, sueldo, isss, fecha_contratacion, fecha_nacimiento, genero, id_area, id_cargo) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->pfp, $this->nombre_empleado, $this->telefono_empleado, $this->dui, $this->correo_electronico, $this->sueldo, $this->isss, $this->fecha_contratacion, $this->fecha_nacimiento, $this->genero, $this->id_area, $this->id_cargo );
        return Database::executeRow($sql, $params);
    }
    
    public function updateRow()
    {
        $sql = 'UPDATE empleado SET pfp = ?, nombre_empleado = ?, telefono_empleado = ?, dui = ?, correo_electronico = ?, sueldo = ?, isss = ?, fecha_contratacion = ?, fecha_nacimiento = ?, genero = ?, id_area = ?, id_cargo = ? WHERE id_empleado = ? ';
        $params = array($this->pfp, $this->nombre_empleado, $this->telefono_empleado, $this->dui, $this->correo_electronico, $this->sueldo, $this->isss, $this->fecha_contratacion, $this->fecha_nacimiento, $this->genero, $this->id_area, $this->id_cargo, $this->id_empleado);
        return Database::executeRow($sql, $params);
    }
    
}
