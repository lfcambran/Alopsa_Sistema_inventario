<?php

require '../config/Conexion.php';

class dashboard{
    public function __construct() {
        
    }
    public function cantidad_ingresos(){
        $sql="select * from ingreso_maestro where estado not in ('Anulado')";
        return numeroitem($sql);
    }
    public function cantidad_tirs(){
        $sql="select * from datostir where estado='Activo'";
        return numeroitem($sql);
    }
    public function cantidad_conexion(){
        $sql="select * from conexion where estado='Activo'";
        return numeroitem($sql);
    }
    public function cantidad_movinterno(){
        $sql="select * from movimientos where Estado='Activo'";
        return numeroitem($sql);
    }
}