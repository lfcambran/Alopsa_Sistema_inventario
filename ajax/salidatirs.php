<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/salidatirs.php';
date_default_timezone_set("America/Guatemala");
$salidatirs = new datostirsalida();
$user_id=$_SESSION['idusuario'];

switch ($_GET['op']){
    case 'listartirs':
        $rspta=$salidatirs->listar_tirsalida();
        echo '<option value="0">Seleccionar..</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->idtir.'>'.$reg->idtir.'-'.$reg->No_Contenedor.'</option>';
        }
        break;
}