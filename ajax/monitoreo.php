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
$user_id=$_SESSION['idusuario'];

switch ($_GET['op']){
    case 'guardaryeditar':
        if (empty($id)){
            $rspta=$monitoreo->insertar($horamonitoreo,$retorno,$observaciones,$producto,$setpoint,$suministro,$fechamonitoreo,$mecanico,$idingreso,$idf,$user_id);
            echo $rspta ? 'Se Ingreso el Monitoreo Exitosamente':'Error al realizar el Monitoreo';
        }else{
            $rspta=$monitoreo->editar($id,$horamonitoreo,$retorno,$observaciones,$producto,$setpoint,$suministro,$fechamonitoreo,$mecanico,$idingreso,$idf,$user_id);
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
                "9"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->Id_m.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Ingreso"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->Id_m.')"><i class="fa fa-close" data-toggle="tooltip" data-placement="top" title="Anular Ingreso"></i></button> '
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
            echo '<option value='.$reg->Id_Ingreso.'>'.$reg->Id_Ingreso.'-'.$reg->No_Contenedor.'</option>';
        }
        break;
    case 'mostraringreso':
        $idingreso=$_REQUEST['idingreso'];
        $rspta=$monitoreo->datosingreso($idingreso);
        while ($row = mysqli_fetch_array($rspta)){
        echo '<div class="form-group col-lg-2 col-md-3 col-xs-12">'
            . '<label>ORD:</label><input type="text" class="form-control" id="ord" name="ord" value="'.$row['Ord'].'" disabled="true">'
            . '</div><div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Producto:</label><input type="text" class="form-control" value="'.$row['producto'].'" disabled="true"></div>'
            . '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Bloque:</label><input type="text" class="form-control" value="'.$row['Descripcion'].'" disabled="true"></div>'
            . '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Posicion:</label><input type="text" class="form-control" value="'.$row['noposicion'].'" disabled="true"></div>'
            . '<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Barco:</label><input type="text" class="form-control" value="'.$row['Barco'].'" disabled="true"></div>'
            . '<input type="hidden" id="id_f" name="id_f" value="'.$row['Id_f'].'">'
            . '<input type="hidden" id="producto" name="producto" value="'.$row['producto'].'" >';
        
        }
        break;
}