<?php
if (strlen(session_id())<1)
    session_start();
require '../modelos/reportes.php';
$reportesg=new reportes_g();

switch ($_GET['op']){
    case 'listatirs':
        $fechainicial= isset($_POST['fechai'])? limpiarCadena($_POST['fechai']):'';
        $fechafinal= isset($_POST['fechaf'])? limpiarCadena($_POST['fechaf']):'';
        $rspta=$reportesg->reportetirs($fechainicial,$fechafinal);
        $datosreporte= array();
        $correlativo=0;
        while ($reg=$rspta->fetch_object()){
            $correlativo+=1;
            $datosreporte[]=array(
                "0"=>$correlativo,
                "1"=>$reg->idtir,
                "2"=>$reg->No_Contenedor,
                "3"=>$reg->chassis,
                "4"=>$reg->SerieTir,
                "5"=>$reg->fecha,
                "6"=>$reg->hora,
                "7"=>$reg->Destino,
                "8"=>$reg->cliente,
                "9"=>$reg->Barco,
                "10"=>$reg->tipomov,
                "11"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtir.')"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Editar Datos TIR"></i></button>'
            );
        }
        $resultado=array(
          "sEcho"=>1,
           "iTotalRecords"=> count($datosreporte),
            "iTotalDisplayRecords"=> count($datosreporte),
            "aaData"=>$datosreporte
        );
        echo json_encode($resultado);
        break;
    case 'listatirsanu':
        $fechainicial= isset($_POST['fechai'])? limpiarCadena($_POST['fechai']):'';
        $fechafinal= isset($_POST['fechaf'])? limpiarCadena($_POST['fechaf']):'';
        $rspta=$reportesg->reportetirsanu($fechainicial,$fechafinal);
        $datosreporte= array();
        $correlativo=0;
        while ($reg=$rspta->fetch_object()){
            $correlativo+=1;
            $datosreporte[]=array(
                "0"=>$correlativo,
                "1"=>$reg->idtir,
                "2"=>$reg->No_Contenedor,
                "3"=>$reg->chassis,
                "4"=>$reg->SerieTir,
                "5"=>$reg->fecha,
                "6"=>$reg->hora,
                "7"=>$reg->Destino,
                "8"=>$reg->cliente,
                "9"=>$reg->Barco,
                "10"=>$reg->tipomov,
                "11"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtir.')"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Editar Datos TIR"></i></button>'
            );
        }
        $resultado=array(
          "sEcho"=>1,
           "iTotalRecords"=> count($datosreporte),
            "iTotalDisplayRecords"=> count($datosreporte),
            "aaData"=>$datosreporte
        );
        echo json_encode($resultado);
        break;
    case 'listaringresos':
        $fechainicial= isset($_POST['fechai'])? limpiarCadena($_POST['fechai']):'';
        $fechafinal= isset($_POST['fechaf'])? limpiarCadena($_POST['fechaf']):'';
        $rspta=$reportesg->reporte_ingresos($fechainicial,$fechafinal);
        $datosreporte= array();
        $correlativo=0;
        while ($reg=$rspta->fetch_object()){
            $estado='';
            if ($reg->Estado=='Ingresado'){
                $estado='<span class="label bg-green">Activo</span>';
            } else {
               $estado='<span class="label bg-orange">'.$reg->Estado.'</span>'; 
            }
            $correlativo+=1;
            $datosreporte[]=array(
                "0"=>$correlativo,
                "1"=>$reg->Id_Ingreso,
                "2"=>$reg->No_Contenedor,
                "3"=>$reg->Fecha_ingreso,
                "4"=>$reg->Hora_ingreso,
                "5"=>$reg->Barco,
                "6"=>$reg->Descripcion_contenido,
                "7"=>$reg->Destino,
                "8"=>$reg->cliente,
                "9"=>$reg->Nombre_de_Piloto,
                "10"=>$estado,
                "11"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->Id_Ingreso.')"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Ver"></i></button>'
            );
        }
        $resultado=array(
          "sEcho"=>1,
           "iTotalRecords"=> count($datosreporte),
            "iTotalDisplayRecords"=> count($datosreporte),
            "aaData"=>$datosreporte
        );
        echo json_encode($resultado);
        break;
}