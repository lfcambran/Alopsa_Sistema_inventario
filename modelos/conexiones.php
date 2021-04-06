<?php

require '../config/Conexion.php';

class conexiones_c{
    public function __construct() {
        
    }
    public function insertar($fechac,$horacon,$setpoint,$suministro,$retorno,$idingreso,$idf,$idusuario){
        $sql="CALL insertar_cone('$fechac','$horacon',$setpoint,$suministro,$retorno,$idingreso,$idf,'$idusuario')";
        return ejecutarConsulta($sql);
    }
    public function listar(){
        $sql="CALL mostrar_conexiones()";
        return ejecutarConsulta($sql);
    }
    public function datosingreso($ingreso){
        $sql="call datosingreso('$ingreso')";
        return ejecutarConsulta($sql);
    }
}