<?php

require '../config/Conexion.php';

class datostirsalida{
    public function __construct() {
        
    }
    public function listar_tirsalida(){
        $sql="select dt.idtir,im.No_Contenedor from datostir dt inner join ingreso_maestro im on dt.idingreso=im.Id_Ingreso where  dt.estado='Activo'";
        return ejecutarConsulta($sql);
    }
}