<?php

require '../config/Conexion.php';

class conexiones_c{
    public function __construct() {
        
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