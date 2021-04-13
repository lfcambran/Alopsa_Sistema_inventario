<?php

require '../config/Conexion.php';

class monitoreo_c{
    
    public function __construct() {
        
    }
    public function insertar($horamonitoreo,$retorno,$observacion,$producto,$setpoint,$suministro,$fecha,$mecanico,$idingreso,$idf,$idusuario,$temperatura){
        $sql="CALL insertar_monitoreo('$horamonitoreo','$retorno','$observacion','$producto','$setpoint','$suministro','$fecha','$mecanico',$idingreso,$idf,$idusuario,'$temperatura')";
        return ejecutarConsulta($sql);
    }
    public function editar($id,$horamonitoreo,$retorno,$observacion,$producto,$setpoint,$suministro,$fecha,$mecanico,$idingreso,$idf,$temperatura){
         $sql="CALL actualizar_monitoreo($id,'$horamonitoreo','$retorno','$observacion','$producto','$setpoint','$suministro','$fecha','$mecanico',$idingreso,$idf,'$temperatura')";
        return ejecutarConsulta($sql);
    }
    public function mostrarm($id){
        $sql="CALL mostrar_datos_monitoreo('$id')";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function listar(){
        $sql="CALL listar_Monitoreo";
        return ejecutarConsulta($sql);
    }
    public function listar_ingreso(){
        $sql="select a.Id,b.No_Contenedor from conexion a INNER join ingreso_maestro b on a.Id_ingreso=b.Id_Ingreso where a.Estado='Activo'";
        return ejecutarConsulta($sql);
    }
    public function datosingreso($ingreso){
        $sql="call datosingreso('$ingreso')";
        return ejecutarConsulta($sql);
    }
    public function desactivar($id){
        $sql="update monitoreo set estado='Inactivo' where Id_m='$id'";
        return ejecutarConsulta($sql);
    }
}