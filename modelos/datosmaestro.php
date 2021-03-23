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
            . ",'$observaciones','$destino','$fechaasig','Ingresado','$idflota','$idusuario'";
    $idingreso= ejecutarConsulta_retornarID($sql);
    $sw=true;
        $sql_posicion="update posicion set estado='Asignado',id_ingreso='$idingreso' where idPosicion='$posicion' and idbloque='$bloque'";
        ejecutarConsulta($sql_posicion) or $sw=false;
        return $sw;
    }
    public function actualizar($id_ingreso,$fecha_ingreso,$hora_ingreso,$no_Contenedor,$barco,$tipocontenido,$dcontenido,$dservicio,$marchamo,$htir,$serietir,$producto,$ord,$bloque,$posicion,$destino,$fechaasig,$idflota,$idusuario,$observaciones) {
        $sql="CALL actualizar_ingreso('$id_ingreso','$fecha_ingreso','$hora_ingreso','$no_Contenedor','$barco','$tipocontenido','$dcontenido','$dservicio','$marchamo','$htir','$serietir','$producto','$ord','$bloque','$posicion','$destino','$fechaasig','$observaciones','Ingresado','$idflota','$idusuario')";
        return ejecutarConsulta($sql);
    }
    public function listar() {
        $sql="SELECT a.Id_Ingreso,b.Nombre_de_Piloto,b.Placas,a.No_Contenedor,a.Marchamo,a.Bloque,a.Posicion,a.producto,a.Barco,a.Destino from ingreso_maestro a 
            inner join flota_transporte b on a.Id_f=b.Id_f 
            WHERE b.Estado=1 and a.Estado='Ingresado'";
           return ejecutarConsulta($sql);
    }
    public function mostraringreso($id){
        $sql="select * from ingreso_maestro where Id_Ingreso='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
}
