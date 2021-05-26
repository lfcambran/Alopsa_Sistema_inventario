<?php
if (strlen(session_id())<1)
    session_start();

require '../modelos/monitoreo.php';
$monitoreo=new monitoreo_c;
$id= isset($_POST['idmonitoreo'])? limpiarCadena($_POST['idmonitoreo']):"";
$idingreso= isset($_POST['contenedor'])? limpiarCadena($_POST['contenedor']):"";
$horamonitoreo= isset($_POST['horamonitoreo'])? limpiarCadena($_POST['horamonitoreo']):"";
$fechamonitoreo= isset($_POST['fecham'])? limpiarCadena($_POST['fecham']):"";
$retorno=isset($_POST['retorno'])? limpiarCadena($_POST['retorno']):"";
$setpoint= isset($_POST['setpoint'])? limpiarCadena($_POST['setpoint']):"";
$suministro= isset($_POST['suministro'])? limpiarCadena($_POST['suministro']):"";
$mecanico= isset($_POST['mecanico'])? limpiarCadena($_POST['mecanico']):"";
$observaciones=isset($_POST['observaciones'])? limpiarCadena($_POST['observaciones']):"";
$idf=isset($_POST['id_f'])? limpiarCadena($_POST['id_f']):"";
$producto=isset($_POST['producto'])? limpiarCadena($_POST['producto']):"";
$temperatura= isset($_POST['temperatura'])? limpiarCadena($_POST['temperatura']):"";
$user_id=$_SESSION['idusuario'];

switch ($_GET['op']){
    case 'guardaryeditar':
        if (empty($id)){
            $rspta=$monitoreo->insertar($horamonitoreo,$retorno,$observaciones,$producto,$setpoint,$suministro,$fechamonitoreo,$mecanico,$idingreso,$idf,$user_id,$temperatura);
            echo $rspta ? 'Se Ingreso el Monitoreo Exitosamente':'Error al realizar el Monitoreo';
        }else{
            $rspta=$monitoreo->editar($id,$horamonitoreo,$retorno,$observaciones,$producto,$setpoint,$suministro,$fechamonitoreo,$mecanico,$idingreso,$idf,$temperatura);
             echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos"; 
        }
        break;
    case 'listar':
        $rspta=$monitoreo->listar();
        $datosm=array();
        
        while ($reg=$rspta->fetch_object()){
            $datosm[]=array(
                "0"=>$reg->No_Contenedor,
                "1"=>$reg->Hora_De_Monitoreo,
                "2"=>$reg->Producto,
                "3"=>$reg->Set_Point,
                "4"=>$reg->Retorno,
                "5"=>$reg->Bloque,
                "6"=>$reg->Posicion,
                "7"=>$reg->Barco,
                "8"=>$reg->Fecha_Del_Monitoreo,
                "9"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->Id_m.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Monitoreo"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->Id_m.')"><i class="fa fa-close" data-toggle="tooltip" data-placement="top" title="Anular Monitoreo"></i></button> '
            );
        }
        $results=array(
            "sEcho"=>1,
            "iTotalRecords"=> count($datosm),
            "iTotalDisplayRecords"=> count($datosm),
            "aaData"=>$datosm
        );
        echo json_encode($results);
        break;
    case 'listaringreso':
        $rspta=$monitoreo->listar_ingreso();
        echo '<option value="0">Selecione Ingreso</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->Id.'>'.$reg->Id.'-'.$reg->No_Contenedor.'</option>';
        }
        break;
    case 'mostraringreso':
        $idingreso=$_REQUEST['idingreso'];
        $rspta=$monitoreo->datosingreso($idingreso);
        while ($row = mysqli_fetch_array($rspta)){
        echo '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Tara:</label><input type="text" class="form-control" id="tara" name="tara" value="'.$row['tara'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Transportista</label><input type="text" class="form-control" value="'.$row['Transporte'].'" disabled="true"><input type="hidden" id="naviera" name="naviera" value="'.$row['Transporte'].'" > </div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Piloto</label><input type="text" class="form-control" value="'.$row['Nombre_de_Piloto'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Licencia</label><input type="text" class="form-control" value="'.$row['Licencias'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Placas</label><input type="text" class="form-control" value="'.$row['Placas'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Codigo</label><input type="text" class="form-control" value="'.$row['Codigo_Piloto_Naviera'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Destino</label><input type="text" class="form-control"  value="'.$row['Destino'].'" disabled="true"><input type="hidden" id="destino" name="destino" value="'.$row['Destino'].'"><input type="hidden" id="idf" name="idf" value="'.$row['Id_f'].'"></div>';

        
        }
        break;
    case 'mostrardatos':
        $idmonitoreo=$_REQUEST['idmon'];
        $rspta=$monitoreo->mostrarm($idmonitoreo);
        echo json_encode($rspta);
        break;
    case 'desactivar':
        $idmo=$_REQUEST['id_m'];
        $rspta=$monitoreo->desactivar($idmo);
         echo $rspta ? "Monitoreo desactivados correctamente" : "No se pudo desactivar el monitoreo";
        break;
}