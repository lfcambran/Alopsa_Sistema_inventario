<?php

require '../config/Conexion.php';

class monitoreo_c{
    
    public function __construct() {
        
    }
    public function insertar($horamonitoreo,$retorno,$observacion,$producto,$setpoint,$suministro,$fecha,$mecanico,$idingreso,$idf,$idusuario){
        $sql="CALL insertar_monitoreo('$horamonitoreo','$retorno','$observacion','$producto','$setpoint','$suministro','$fecha','$mecanico',$idingreso,$idf,$idusuario)";
        return ejecutarConsulta($sql);
    }
    public function editar($id,$horamonitoreo,$retorno,$observacion,$producto,$setpoint,$suministro,$fecha,$mecanico,$idingreso,$idf,$idusuario){
         $sql="CALL actualizar_monitoreo()";
        return ejecutarConsulta($sql);
    }
    public function mostrarm($id){
        $sql="";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function listar(){
        $sql="CALL listar_Monitoreo";
        return ejecutarConsulta($sql);
    }
    public function listar_ingreso(){
        $sql="select Id_Ingreso,No_Contenedor from ingreso_maestro where Estado='ingresado'";
        return ejecutarConsulta($sql);
    }
    public function datosingreso($ingreso){
        $sql="call datosingreso('$ingreso')";
        return ejecutarConsulta($sql);
    }
}