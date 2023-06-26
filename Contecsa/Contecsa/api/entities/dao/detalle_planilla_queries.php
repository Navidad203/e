<?php
require_once('../../helpers/database.php');

// clases en PHP inicial mayuscula cada palabra su nombre es StudlyCaps

/*funcion para leer datos*/
class DetallePlanillaQueries
{
    // consulta para que me cargue todos los datos de la tabla producto y lo ocupar en sitio privado 
    public function readAll()
    {
        $sql = 'SELECT id_detalle_planilla, planilla.id_planilla,detalle_comision.id_detalle_comision, detalle_comision.id_servicio, servicio.id_empleado, empleado.nombre_empleado, usuario.nombre_usuario,horas_extra.valor, detalle_planilla.salario_base,detalle_planilla.total_descuento
        FROM detalle_planilla    
		INNER JOIN planilla USING(id_planilla)
		INNER JOIN detalle_comision USING(id_detalle_comision)
        INNER JOIN usuario USING(id_usuario) 
        INNER JOIN horas_extra USING(id_horas_extra)
		INNER JOIN servicio USING (id_servicio)
		INNER JOIN empleado USING (id_empleado)';
        return Database::getRows($sql);
    }

    public function readAllPlanilla(){
        $sql = 'SELECT id_detalle_planilla, planilla.id_planilla, planilla.dias_trabajados, planilla.fecha_inicio , planilla.fecha_fin, planilla.estado_planilla
        FROM detalle_planilla 
        INNER JOIN planilla USING (id_planilla)
        WHERE id_detalle_planilla = ?';
        $params = array($this->id_detalle_planilla);
        return Database::getRows($sql,$params);
    }

    public function readAllDetalle(){
        $sql = 'SELECT id_detalle_planilla, detalle_comision.id_detalle_comision,  servicio.nombre_servicio, detalle_comision.id_servicio, servicio.id_empleado, empleado.nombre_empleado, detalle_comision.porcentaje, detalle_comision.monto
        FROM detalle_planilla 
        INNER JOIN detalle_comision USING (id_detalle_comision)
		INNER JOIN servicio USING (id_servicio)
		INNER JOIN empleado USING (id_empleado)
        WHERE id_detalle_planilla = ?';
        $params = array($this->id_detalle_planilla);
        return Database::getRows($sql,$params);
    }

//    otro estandar es que las variables van en minuscula como por ejemplo $sql,$params
// consulta para los bucadores segun el nombre del producto este se ocupa en el sitio privado
// estandar de programacion que se aplica camelCase 
    public function searchRows($value)
    {
        $sql = 'SELECT id_detalle_planilla, planilla.id_planilla,detalle_comision.id_detalle_comision, detalle_comision.id_servicio, servicio.id_empleado, empleado.nombre_empleado, usuario.nombre_usuario,horas_extra.valor, detalle_planilla.salario_base,detalle_planilla.total_descuento
        FROM detalle_planilla
        INNER JOIN planilla USING(id_planilla)
		INNER JOIN detalle_comision USING(id_detalle_comision)
        INNER JOIN usuario USING(id_usuario) 
        INNER JOIN horas_extra USING(id_horas_extra)
		INNER JOIN servicio USING (id_servicio)
		INNER JOIN empleado USING (id_empleado)
        WHERE nombre_empleado ILIKE ? OR nombre_usuario ILIKE ?
        ORDER BY nombre_empleado';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    /*funcion para eliminar datos*/
    public function deleteRow()
    {
        $sql = 'DELETE FROM detalle_planilla
                WHERE id_detalle_planilla = ?';
        $params = array($this->id_detalle_planilla);
        return Database::executeRow($sql, $params);
    }

    /*funcion para leer datos*/
    public function readOne()
    {
        $sql = 'SELECT * FROM detalle_planilla
                WHERE id_detalle_planilla = ?';
        $params = array($this->id_detalle_planilla);
        return Database::getRow($sql, $params);
    }

    
    /*cargar combox */

    public function readPlanilla()
    {
        $sql = 'SELECT id_planilla, fecha_inicio FROM planilla';
        return Database::getRows($sql);
    }

    public function readComision()
    {
        $sql = 'SELECT id_detalle_comision, porcentaje FROM detalle_comision';
        return Database::getRows($sql);
    }

    public function readUsuario()
    {
        $sql = 'SELECT id_usuario, nombre_usuario FROM usuario';
        return Database::getRows($sql);
    }

    public function readHoras_extra()
    {
        $sql = 'SELECT id_horas_extra, valor FROM horas_extra';
        return Database::getRows($sql);
    }

    /*funcion para crear insercion*/

    public function createRow()
    {
        $sql = 'INSERT INTO detalle_planilla(id_planilla, id_detalle_comision, id_usuario, id_horas_extra, salario_base, total_descuento) 
        VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->id_planilla, $this->id_detalle_comision, $this->id_usuario, $this->id_horas_extra, $this->salario_base, $this->total_descuento,);
        return Database::executeRow($sql, $params);
    }
    
    public function updateRow()
    {
        $sql = 'UPDATE detalle_planilla SET id_planilla = ?, id_detalle_comision = ?, id_usuario = ?, id_horas_extra = ?, salario_base = ?, total_descuento = ? WHERE id_detalle_planilla= ? ';
        $params = array($this->id_planilla, $this->id_detalle_comision, $this->id_usuario, $this->id_horas_extra, $this->salario_base, $this->total_descuento, $this->id_detalle_planilla);
        return Database::executeRow($sql, $params);
    }

}
