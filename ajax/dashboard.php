<?php

session_start();

require '../modelos/dashboard.php';

$dashboard=new dashboard();

switch ($_GET['op']){
    case 'cantidad_ingreso_maestros':
        $rspta=$dashboard->cantidad_ingresos();
        echo json_encode($rspta);
        break;
    case 'cantidad_tirs':
        $rspta=$dashboard->cantidad_tirs();
        echo json_encode($rspta);
        break;
    case 'Cantidad_conexion':
        $rspta=$dashboard->cantidad_conexion();
        echo json_encode($rspta);
        break;
    case 'cantidad_movinterno':
        $rspta=$dashboard->cantidad_movinterno();
        echo json_encode($rspta);
        break;
}