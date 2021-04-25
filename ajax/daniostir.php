<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/datostir.php';
$datosTIR=new datostir;
switch ($_GET['op']){
       case 'listar':
           $rspta=$datosTIR->listar();
           $datos_tir=array();
            while ($reg=$rspta->fetch_object()){
                $datos_tir[]=array(
                    "0"=>$reg->No_Contenedor,
                    "1"=>$reg->chassis,
                    "2"=>$reg->SerieTir,
                    "3"=>$reg->numeroTIR,
                    "4"=>$reg->fecha,
                    "5"=>$reg->hora,
                    "6"=>$reg->Transporte,
                    "7"=>$reg->Nombre_de_Piloto,
                    "8"=>$reg->Placas,
                    "9"=>$reg->Destino,
                    "10"=>$reg->vacio,
                    "11"=>$reg->cliente,
                    "12"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtir.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Monitoreo"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->idtir.')"><i class="fa fa-close" data-toggle="tooltip" data-placement="top" title="Anular Monitoreo"></i></button> '
                );
            }
            $results=array(
            "sEcho"=>1,
            "iTotalRecords"=> count($datos_tir),
            "iTotalDisplayRecords"=> count($datos_tir),
            "aaData"=>$datos_tir
        );
        echo json_encode($results);
           break;
       case 'listaringreso':
        $rspta=$datosTIR->listar_ingreso();
        echo '<option value="0">Selecione Ingreso</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->Id_Ingreso.'>'.$reg->Id_Ingreso.'-'.$reg->No_Contenedor.'</option>';
        }
        break;
        
        case 'mostraringreso':
            $idingreso=$_REQUEST['iding'];
            $rspta=$datosTIR->datosingreso($idingreso);
            while ($row= mysqli_fetch_array($rspta)){
            echo '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Chassis</label><input type="text" class="form-control" id="chassis" name="chassis"></div>'
                . '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>ORD</label><input type="text" class="form-control" id="ord" name="ord" value="'.$row['ord'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Transportista</label><input type="text" class="form-control" value="'.$row['Transporte'].'" disabled="true"> </div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Piloto</label><input type="text" class="form-control" value="'.$row['Nombre_de_Piloto'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Licencia</label><input type="text" class="form-control" value="'.$row['Licencias'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Placas</label><input type="text" class="form-control" value="'.$row['Placas'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Codigo</label><input type="text" class="form-control" value="'.$row['Codigo_Piloto_Naviera'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Destino</label><input type="text" class="form-control" value="'.$row['Destino'].'" disabled="true"></div>';

            }
            break;
       case 'listardanios':
           $utfalla=$_REQUEST['udanio'];
           $rspta=$datosTIR->listar_danios($utfalla);
           echo '<option value="0">Seleccione..</option>';
           while ($reg=$rspta->fetch_object()){
               echo '<option value='.$reg->falla.'>'.$reg->falla.'</option>';
           }
           
           break;
}