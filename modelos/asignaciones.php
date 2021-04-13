<?php

require '../config/Conexion.php';

class asignaciones{
    
    public function __construct(){
        
    }
    public function listarasignaciones(){
        $sql="CALL listar_asignaciones()";
        return ejecutarConsulta($sql);
    }
    public function listar_ingresos(){
        $sql="select Id_Ingreso, No_Contenedor from ingreso_maestro where estado='Ingresado'";
        return ejecutarConsulta($sql);
    }
}