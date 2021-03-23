<?php

require '../config/Conexion.php';

class flota{
    
    public function __construct() {
        
    }
    public function insertar($cabezal,$piloto,$licencia,$placas,$codigon,$naviera,$user_id,$transporte,$ubicacion) {
     $sql="INSERT INTO flota_transporte (Cabezal, Nombre_de_Piloto, Licencias, Placas, Codigo_Piloto_Naviera, Naviera, Creadopor, Estado, Fechacreacion, Transporte, Ubicacion)
              VALUES('$cabezal','$piloto','$licencia','$placas','$codigon','$naviera','$user_id','1',NOW(),'$transporte','$ubicacion')";
                $sw=true;
        ejecutarConsulta($sql) or $sw=false;
        return $sw;
    }
    public function editar($id,$cabezal,$piloto,$licencia,$placas,$codigon,$naviera,$user_id,$transporte,$ubicacion) {
        $sql="UPDATE flota_transporte SET cabezal='$cabezal',Nombre_de_Piloto='$piloto',Licencias='$licencia',Placas='$placas',Codigo_Piloto_Naviera='$codigon',Naviera='$naviera',Transporte='$transporte',Ubicacion='$ubicacion'
                 WHERE Id_f='$id'"; 
        return ejecutarConsulta($sql);
        
    }
    public function desactivar($id){
        $sql="UPDATE flota_transporte SET estado='0' where Id_f='$id'";
        return ejecutarConsulta($sql);
    }
    public function activar($id){
         $sql="UPDATE flota_transporte SET estado='1' where Id_f='$id'";
        return ejecutarConsulta($sql);
    }
    public function mostrar($id){
        $sql="SELECT * FROM flota_transporte where Id_f='$id'";
       return ejecutarConsultaSimpleFila($sql);
    }
    public function mostrar_datos($id) {
        $sql="SELECT * FROM flota_transporte where Id_f='$id'";
        return ejecutarConsulta($sql);
    }
    public function listar() {
        $sql="select Id_f, Cabezal, Nombre_de_Piloto, Licencias, Placas, Codigo_Piloto_Naviera, Naviera, Transporte, Ubicacion  from flota_transporte where Estado=1";
        return ejecutarConsulta($sql);
    }
    public function mostrar_lista() {
        $sql ="select Id_f,Nombre_de_Piloto from flota_transporte where estado='1'";
        return ejecutarConsulta($sql);
    }
    
}