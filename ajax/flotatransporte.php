<?php
if (strlen(session_id())<1)
    session_start();
require '../modelos/flotatransporte.php';

$flota=new flota();

$id= isset($_POST["codigoid"])? limpiarCadena($_POST["codigoid"]):"";
$cabezal= isset($_POST["cabezal"])? limpiarCadena($_POST["cabezal"]):"";
$piloto= isset($_POST["nombrepiloto"])? limpiarCadena($_POST["nombrepiloto"]):"";
$licencia = isset($_POST["licencia"])? limpiarCadena($_POST["licencia"]):"";
$placas= isset($_POST["placas"])? limpiarCadena($_POST["placas"]):"";
$codpil_nav= isset($_POST["codigon"])? limpiarCadena($_POST["codigon"]):"";
$naviera= isset($_POST["naviera"])? limpiarCadena($_POST["naviera"]):"";
$transporte= isset($_POST["transporte"])? limpiarCadena($_POST["transporte"]):"";
$ubicacion= isset($_POST["ubicacion"])? limpiarCadena($_POST["ubicacion"]):"";
$user_id=$_SESSION["nombre"];

switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($id)){
            $rspta=$flota->insertar($cabezal,$piloto,$licencia,$placas,$codpil_nav,$naviera,$user_id,$transporte,$ubicacion);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        }else {
            $rspta=$flota->editar($id,$cabezal,$piloto,$licencia,$placas,$codpil_nav,$naviera,$user_id,$transporte,$ubicacion);
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos"; 
        }
        break;
    case 'desactivar':
        $rspta=$flota->desactivar($id);
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
        break;
    case 'activar':
        $rspta=$flota->activar($id);
        echo  $rspta ? "Datos activado correctamente" : "No se pudo desactivar los datos";
        break;
    case 'mostrar':
        $rspta=$flota->mostrar($id);
        echo json_encode($rspta);
        break;
    case 'mostrardatos':
        $piloto_id=$_REQUEST["idpiloto"];
        $rspta=$flota->mostrar_datos($piloto_id);
        while ($row = mysqli_fetch_array($rspta)){
        echo '<div class="form-group col-lg-2 col-md-3 col-xs-12">'
            . '<label>Cabezal:</label><input type="text" class="form-control " value="'.$row['Cabezal'].'" disabled="true">'
            . '</div><div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Placas:</label><input type="text" class="form-control" value="'.$row['Placas'].'" disabled="true"></div>'
            . '<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Licencia:</label><input type="text" class="form-control" value="'.$row['Licencias'].'" disabled="true"></div>'
            . '<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Codigo Naviera:</label><input type="text" class="form-control" value="'.$row['Codigo_Piloto_Naviera'].'" disabled="true"></div>';
        }
        break;
    case 'listar':
        
        $rspta=$flota->listar();        
        $data=Array();
        
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->Id_f.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Piloto"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->Id_f.')" data-toggle="tooltip" data-placement="top" title="Anular"><i class="fa fa-close"></i></button>',
                "1"=>$reg->Cabezal,
                "2"=>$reg->Nombre_de_Piloto,
                "3"=>$reg->Licencias,
                "4"=>$reg->Placas,
                "5"=>$reg->Codigo_Piloto_Naviera,
                "6"=>$reg->Naviera,
                "7"=>$reg->Transporte,
                "8"=>$reg->Ubicacion
                );
            
        }
         $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
        break;
        case 'selectflota':
            $rspta=$flota->mostrar_lista();
            echo '<option value="0">Seleccione Piloto..</option>';
                    while ($reg=$rspta->fetch_object()){
                        echo '<option value='.$reg->Id_f.'>'.$reg->Nombre_de_Piloto.'</option>';
                    }
            break;
    
}

?>
