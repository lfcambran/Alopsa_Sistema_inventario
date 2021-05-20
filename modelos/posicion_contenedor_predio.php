<?php

require '../config/Conexion.php';

class posicion_cont_predio{
    public function __construct() {
        
    }
    public function listar_ingresos_conte(){
         $sql="select Id_Ingreso,No_Contenedor from ingreso_maestro where estado='Ingresado'";
        return ejecutarConsulta($sql);
    }
    public function datosingresoco($val){
          $sql="call datosingreso_datostir($val)";
        return ejecutarConsulta($sql);
    }
    public function listar_patio() {
        $sql="select * from patios";
        return ejecutarConsulta($sql);
    }
    public function listar_area($val){
        $sql="select ap.id_area,ap.area,p.id_patio from areas_patio ap inner join patios p on ap.id_patio = p.id_patio where ap.id_patio =$val";
        return ejecutarConsulta($sql);
    }
    public function listar_bloque($area) {
        $sql="select b.id_bloque,b.Descripcion,ap.area from bloque b inner join areas_patio ap on b.id_area =ap.id_area where b.id_area =$area";
        return ejecutarConsulta($sql);
    }
    public function listar_fila($bloque) {
        $sql="select f.idfila,f.fila ,b.Descripcion from fila f inner join bloque b on f.idbloque = b.id_bloque where f.idbloque =$bloque";
        return ejecutarConsulta($sql);
    }
    public function numero_altura($idfila) {
        $sql="select * from altura_predio ap where ap.id_fila = $idfila and estado='sin Asignar' order by altura asc limit 1";
        return ejecutarConsulta($sql);
        
    }
}
