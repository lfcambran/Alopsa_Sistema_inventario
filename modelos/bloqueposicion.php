<?php

require '../config/Conexion.php';

class bloqueposicion {
    public function __construct() {
        
    }
    public function insert_bloque($Descripcion){
        $sql="insert into bloque (descripcion) values ('$Descripcion')";
        $sw=true;
        ejecutarConsulta($sql) or $sw=false;
        return $sw;
    }
    public function insert_posicion($bloque,$noPosicion) {
        $sql="insert into posicion (noposicion,estado,idbloque) values ('$noPosicion','Sin Asignar','$bloque')";
        $sw=true;
        ejecutarConsulta($sql) or $sw=false;
        return $sw;
    }
    public function listar_bloque(){
        $sql="select * from bloque";
        return ejecutarConsulta($sql);
    }
    public function listar_posicion($idbloque){
        $sql="select * from posicion where idbloque='$idbloque' and estado='Sin Asignar'";
        return ejecutarConsulta($sql);
    }
}