<?php

require '../config/Conexion.php';

class datostir{
     public function __construct() {
        
    }
       public function listar(){
           $sql="CALL mostrar_datostir()";
           return ejecutarConsulta($sql);
       }
       public function listar_ingreso(){
        $sql="select Id_Ingreso,No_Contenedor from ingreso_maestro where estado='Ingresado'";
        return ejecutarConsulta($sql);
    }
}