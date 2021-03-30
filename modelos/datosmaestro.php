<?php

require '../config/Conexion.php';

class datosm{
    
    public function __construct() {
        
    }
    public function insertar($fecha_ingreso,$hora_ingreso,$no_Contenedor,$barco,$tipocontenido,$dcontenido,$dservicio,$marchmo,$htir,$serietir,$producto,$ord,$bloque,$posicion,$destino,$fechaasig,$idflota,$idusuario,$observaciones) {
    $sql="INSERT INTO ingreso_maestro(Fecha_ingreso, Hora_ingreso, No_Contenedor, Barco, Tipo_Contenido, "
            . "Descripcion_contenido, Detalle_Servicio, Marchamo, Hora_TIR, Serie_TIR, producto, Ord, Bloque,"
            . " Posicion, Observaciones, Destino, Fecha_Asignacion, Estado, Id_f, id_usuario) VALUES ('$fecha_ingreso','$hora_ingreso'"
            . ",'$no_Contenedor','$barco','$tipocontenido','$dcontenido','$dservicio','$marchmo','$htir','$serietir','$producto','$ord','$bloque','$posicion'"
            . ",'$observaciones','$destino','$fechaasig','Ingresado','$idflota','$idusuario')";
    $idingreso= ejecutarConsulta_retornarID($sql);
    $sw=true;
        $sql_posicion="update posicion set estado='Asignado',id_ingreso='$idingreso' where idPosicion='$posicion' and idbloque='$bloque'";
        ejecutarConsulta($sql_posicion) or $sw=false;
        return $sw;
    }
    public function actualizar($id_ingreso,$fecha_ingreso,$hora_ingreso,$no_Contenedor,$barco,$tipocontenido,$dcontenido,$dservicio,$marchamo,$htir,$serietir,$producto,$ord,$bloque,$posicion,$destino,$fechaasig,$idflota,$idusuario,$observaciones) {
        $sql="CALL actualizar_ingreso('$id_ingreso','$fecha_ingreso','$hora_ingreso','$no_Contenedor','$barco','$tipocontenido','$dcontenido','$dservicio','$marchamo','$htir','$serietir','$producto','$ord','$bloque','$posicion','$destino','$fechaasig','$observaciones','$idflota','$idusuario')";
        return ejecutarConsulta($sql);
    }
    public function listar() {
        $sql="SELECT a.Id_Ingreso,b.Nombre_de_Piloto,b.Placas,a.No_Contenedor,a.Marchamo,c.Descripcion Bloque,d.noPosicion Posicion,a.producto,a.Barco,a.Destino,a.Estado,a.Bloque idb,a.Posicion idp from ingreso_maestro a 
            inner join flota_transporte b on a.Id_f=b.Id_f 
            inner join bloque c on a.Bloque=c.id_bloque
            inner join posicion d on a.Posicion=d.idPosicion and a.Bloque=d.idbloque
            WHERE b.Estado=1 and a.Estado in('Ingresado','Anulado')";
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
