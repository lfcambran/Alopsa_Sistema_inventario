<?php

require '../config/Conexion.php';

class exportacion{
    public function __construct() {
        
    }
    public function listar(){
        $sql="call mostrar_exportacion()";
        return ejecutarConsulta($sql);
    }
    public function listar_contenedores(){
        $sql="select * from ingreso_maestro where estado in('Ingresado','Asignado','Exportado')";
        return ejecutarConsulta($sql);
    }
    public function datoscontenedor($id){
        $sql="CALL datosingreso_exp($id)";
        return ejecutarConsulta($sql);
    }
    public function insertar($fechaexpo,$horaexpo,$fechaasig,$idingreso,$idflota,$user_id){
       $insertado=true;
       $completo=true;
        $sql="CALL inserta_expo('$fechaexpo','$horaexpo','$fechaasig',$idingreso,$idflota,$user_id)";
      
        $insertado=ejecutarConsulta($sql);
        if ($insertado==true){
            $sql2="update ingreso_maestro set estado='Exportado' where Id_Ingreso=$idingreso";
            return ejecutarConsulta($sql2);
                 
        }else {
            return false;
        }
    }
    public function actualizar($idexpo,$fechaexpo,$horaexpo,$fechaasig,$idingreso,$idflota){
        $sql="call actualizar_expo($idexpo,'$fechaexpo','$horaexpo','$fechaasig',$idingreso,$idflota)";
        return ejecutarConsulta($sql);
    }
    public function mostrar($idexpo){
        $sql="select * from exportacion where Id_e=$idexpo";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function anular($idexpo,$idingreso){
        $completo=true;
        $sql="update exportacion set estado='Anulado' where Id_e=$idexpo";
        $completo=ejecutarConsulta($sql);
        if ($completo==true){
            $sql2="update ingreso_maestro set estado='Ingresado' where Id_Ingreso=$idingreso";
            return ejecutarConsulta($sql2);
        }else {
            return false;
        }
    }
}