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
    public function datosingreso($ingreso){
         $sql="call datosingreso_datostir('$ingreso')";
        return ejecutarConsulta($sql);
    }
    public function listar_danios($ufalla){
        $sql="select * from dfallatir where utfalla='$ufalla'";
        return ejecutarConsulta($sql);
    }
    public function inserta_detalle_tir($id,$ubicacion,$descd,$op,$pos,$obser){
        $sql="CALL insert_fallastir($id,'$ubicacion','$descd',$op,'$obser','$pos')";
        return ejecutarConsulta($sql);
    }
    public function Insertar($serietir,$nochasis,$tchasis,$refre,$tcnte,$fecha,$hora,$tmov,$naviera,$vacio,$detino,$fiz,$fder,$ffr,$fint,$ftra,$fte,$fcha,$cliente,$observ,$idingreso,$idf,$idusuario){
        $sql="CALL insert_tir('$serietir','$nochasis','$tchasis','$refre','$tcnte','$fecha','$hora','$tmov','$naviera','$vacio','$detino',$fiz,$fder,$ffr,$fint,$ftra,$fte,$fcha,'$observ','$cliente','$idingreso',$idf,$idusuario)";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    public function actualizar() {
        
    }
    public function listar_tchasis(){
        $sql="select * from tamaniochasis";
        return ejecutarConsulta($sql);
    }
    public function listar_tcontenedores(){
        $sql="select * from tipocontenedor";
        return ejecutarConsulta($sql);
    }
    public function mostrar_tir($idtir){
        $sql="CALL mostrar_datos_tir($idtir)";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function listar_detallatir($idtir){
        $sql="select * from fallas_tir where id_datostir=$idtir";
        return ejecutarConsulta($sql);
    } 
}