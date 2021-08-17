<?php

require '../config/Conexion.php';

class reportes_g{
    public function __construct() {
        
    }
    public function reportetirs($fechai,$fechaf){
        $sql="call reportes_tirs('$fechai','$fechaf','rep')";
        return ejecutarConsulta($sql);
    }
    public function reportetirs_ex($fechai,$fechaf){
         $sql="call reportes_tirs('$fechai','$fechaf','exp')";
        return ejecutarConsulta($sql);
    }
    public function reportetirsanu($fechai,$fechaf){
        $sql="call reportes_tirs('$fechai','$fechaf','anu')";
        return ejecutarConsulta($sql);
    }
    public function reportetirs_ex_anu($fechai,$fechaf){
        $sql="call reportes_tirs('$fechai','$fechaf','anu_ex')";
        return ejecutarConsulta($sql);
    }
    public function reporte_ingresos($fechai,$fechaf){
        $sql="call reportes_ingreso('$fechai','$fechaf')";
        return ejecutarConsulta($sql);
    }

}   
    

?>