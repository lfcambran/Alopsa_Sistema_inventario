<?php

require '../config/Conexion.php';

class datosm{
    
    public function __construct() {
        
    }
    //public function insertar($fecha_ingreso,$hora_ingreso,$no_Contenedor,$barco,$tipocontenido,$dcontenido,$dservicio,$marchmo,$htir,$serietir,$producto,$ord,$bloque,$posicion,$destino,$fechaasig,$idflota,$idusuario,$observaciones,$tara) {
   /* $sql="INSERT INTO ingreso_maestro(Fecha_ingreso, Hora_ingreso, No_Contenedor, Barco, Tipo_Contenido, "
            . "Descripcion_contenido, Detalle_Servicio, Marchamo, Hora_TIR, Serie_TIR, producto, Ord, Bloque,"
            . " Posicion, Observaciones, Destino, Fecha_Asignacion, Estado, Id_f, id_usuario) VALUES ('$fecha_ingreso','$hora_ingreso'"
            . ",'$no_Contenedor','$barco','$tipocontenido','$dcontenido','$dservicio','$marchmo','$htir','$serietir','$producto','$ord','$bloque','$posicion'"
            . ",'$observaciones','$destino','$fechaasig','Ingresado','$idflota','$idusuario')";
             $sw=true;
        $sql_posicion="update posicion set estado='Asignado',id_ingreso='$idingreso' where idPosicion='$posicion' and idbloque='$bloque'";
        ejecutarConsulta($sql_posicion) or $sw=false;
        return $sw;
    }
    *     */
    
    public function insertar($fecha_ingreso,$hora_ingreso,$no_Contenedor,$barco,$tipocontenido,$dcontenido,$dservicio,$destino,$idflota,$idusuario,$observaciones,$tara) {  
    $sql="INSERT INTO ingreso_maestro(Fecha_ingreso,Hora_ingreso,No_Contenedor,Barco,Tipo_Contenido, "
            ."Descripcion_contenido, Detallae_Servicio,Observaciones,Destino,Estado,Id_f,id_usuario,tara)"
            ." values( '$fecha_ingreso','$hora_ingreso','$no_Contenedor','$barco','$tipocontenido','$dcontenido','$dservicio' "
            .",'$observaciones','$destino','Ingresado','$idflota','$idusuario',$tara )";  
    return ejecutarConsulta($sql);
   
    }
   /* public function actualizar($id_ingreso,$fecha_ingreso,$hora_ingreso,$no_Contenedor,$barco,$tipocontenido,$dcontenido,$dservicio,$marchamo,$htir,$serietir,$producto,$ord,$bloque,$posicion,$destino,$fechaasig,$idflota,$idusuario,$observaciones) {
        $sql="CALL actualizar_ingreso('$id_ingreso','$fecha_ingreso','$hora_ingreso','$no_Contenedor','$barco','$tipocontenido','$dcontenido','$dservicio','$marchamo','$htir','$serietir','$producto','$ord','$bloque','$posicion','$destino','$fechaasig','$observaciones','$idflota','$idusuario')";
        return ejecutarConsulta($sql);
    }*/
    public function actualizar($id_ingreso,$fecha_ingreso,$hora_ingreso,$no_Contenedor,$barco,$tipocontenido,$dcontenido,$dservicio,$destino,$idflota,$idusuario,$observaciones,$tara){
        $sql="CALL actualizar_ingresom('$id_ingreso','$fecha_ingreso','$hora_ingreso','$no_Contenedor','$barco','$tipocontenido','$dcontenido','$dservicio','$destino','$observaciones','$idflota','$idusuario',$tara)";
        return ejecutarConsulta($sql);
    }
    public function listar() {
        $sql="call listardatosm()";
           return ejecutarConsulta($sql);
    }
    public function mostraringreso($id){
        $sql="select * from ingreso_maestro where Id_Ingreso='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function desactivar($id,$bloque,$posicion){
        $sql="update ingreso_maestro set estado='Anulado' where Id_Ingreso='$id'";
         ejecutarConsulta($sql);
         $sw=true;
        $sql2="update posicion set estado ='Sin Asignar', id_ingreso='' where noPosicion='$posicion' and idbloque='$bloque'";
        ejecutarConsulta($sql2) or $sw=false;
        return $sw;
    }
    public  function activar($id,$bloque,$posicion){
        $sqlcount="select * from posicion where idbloque='$bloque' and noPosicion='$posicion' and estado='Asignado'";
        if (numeroitem($sqlcount)==0){
            $sql="update ingreso_maestro set estado='Ingresado' where Id_Ingreso='$id'";
             $sw=true;
              ejecutarConsulta($sql);
              $sql2="update posicion set estado='Asignado', id_ingreso='$id' where noPosicion='$posicion' and idbloque='$bloque'";
              ejecutarConsulta($sql2) or $sw=false;
              return $sw;
        }else{
            return false;
        }
        
    }
}
