<?php

require '../config/Conexion.php';

class desconexiones{
    public function __construct() {
        
    }
    public function listar(){
        $sql="CALL mostrar_desconexion()";
        return ejecutarConsulta($sql);
    }
    public function listarconexiones(){
        $sql="select a.Id,b.No_Contenedor from conexion a inner join ingreso_maestro b on a.Id_ingreso=b.Id_Ingreso where a.Estado='Activo' and b.Estado='Ingresado'";
        return ejecutarConsulta($sql);
    }
    public function datosconexion($id){
        $sql="CALL datosconexion($id)";
        return ejecutarConsulta($sql);
    }
}