<?php

require '../config/Conexion.php';

class movinterno{
    public function __construct(){
        
    }
    public function listar_ingreso(){
        $sql="select cpp.id_ingre_m,im.No_Contenedor from contenedor_posicion_patio cpp INNER JOIN ingreso_maestro im on cpp.id_ingre_m=im.Id_Ingreso where cpp.estado='Ingresado'";
        return ejecutarConsulta($sql);
    }
    public function listar_ingresoc(){
        $sql="select cpp.id_ingre_m,im.No_Contenedor from contenedor_posicion_patio cpp INNER JOIN ingreso_maestro im on cpp.id_ingre_m=im.Id_Ingreso where cpp.estado='Ingresado'";
        return ejecutarConsulta($sql);
    }
    public function listar_patio(){
         $sql="select * from patios";
        return ejecutarConsulta($sql);
    }
    public function medida_contenedor(){
        $sql="select * from medida_contenedores";
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
    public function bloque_cont($idc) {
        $sql="select b.Descripcion from contenedor_posicion_patio cpp inner JOIN bloque b on b.id_bloque=cpp.idbloque
                where cpp.id_ingre_m=$idc";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function insertar($semana,$anio,$fecha,$hora,$contenedor,$bloquea,$medida,$patio,$area,$bloque,$cliente,$activada,$motivo,$opcion,$idusuario){
        $sql="call insertar_movinterno($semana,$anio,'$fecha','$hora',$contenedor,$bloquea,$medida,$patio,$area,$bloque,'$cliente','$activada','$motivo','$opcion',$idusuario)";
        return ejecutarConsulta($sql);
    }
    public function actualizar($idmovi,$semana,$anio,$fecha,$hora,$contenedor,$bloquea,$medida,$patio,$area,$bloque,$cliente,$activada,$motivo,$opcion){
        $sql="call actualizar_movinterno($idmovi,$semana,$anio,'$fecha','$hora',$contenedor,$bloquea,$medida,$patio,$area,$bloque,'$cliente','$activada','$motivo','$opcion')";
        return ejecutarConsulta($sql);
    }
}