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
    case 'cantida_tirscerrado':
        $rspta=$dashboard->cantidad_tirscerrados();
        echo json_encode($rspta);
        break;
    case 'grafica_linea':
        $json_data=array(); 
        $rspta=$dashboard->grafica_linea();
        while ($reg=$rspta->fetch_object()){
          $json_array['period']=$reg->fecha;  
          $json_array['total']=$reg->total;
          array_push($json_data,$json_array);
        }
        echo json_encode($json_data,JSON_UNESCAPED_UNICODE);
        break;
}