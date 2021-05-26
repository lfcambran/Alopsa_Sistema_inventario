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
    public function insertar($fecha,$hora,$idpatio,$idarea,$idbloque,$idfila,$altura,$idusario,$idingreso,$idf,$observaciones,$idaltura){
        $insertado=true;
        $actualizado=true;
        $sql="CALL insertar_posicion_con('$fecha','$hora',$idpatio,$idarea,$idbloque,$idfila,$altura,$idusario,$idingreso,$idf,'$observaciones',$idaltura)";
        $insertado= ejecutarConsulta($sql);
        if ($insertado==true){
            $sql2="update altura_predio set estado='Asignado',id_ingresoc=$idingreso where id_altura=$idaltura";
            $actualizado=ejecutarConsulta($sql2);
        
        if ($actualizado==true){
            return true;
        }else{
            return false;
        }
        }else{
            return false;
        }
    }
    public function actualizar($idposicion,$fecha,$hora,$idpatio,$idarea,$idbloque,$idfila,$altura,$idingreso,$idf,$observaciones,$idaltura){
        $sql="CALL actualizar_Posicion_con($idposicion,'$fecha','$hora',$idpatio,$idarea,$idbloque,$idfila,$altura,$idingreso,$idf,'$observaciones',$idaltura)";
        return ejecutarConsulta($sql);
    }
    public function listar_cont_pos(){
        $sql="CALL mostrar_cont_pos()";
        return ejecutarConsulta($sql);
    }
    public function mostrar($id){
        $sql="select * from contenedor_posicion_patio where id_conte_posi=$id";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function desactivar($id,$ida){
        $sw=true;
        $sql="Update contenedor_posicion_patio set estado='Anulado' where id_conte_posi=$id";
        $sw= ejecutarConsulta($sql);
        if ($sw==true){
            $ac==true;
            $sql2="update altura_predio set estado='Sin Asignar', id_ingresoc=0 where id_altura=$ida";
            
             $ac=ejecutarConsulta($sql2) or false;
             if ($ac==true){
                 $sql3="update ingreso_maestro SET Estado='Ingresado' where Id_Ingreso=$idingreso";
                 return ejecutarConsulta($sql3) or false; 
             }
        }
    }
}
