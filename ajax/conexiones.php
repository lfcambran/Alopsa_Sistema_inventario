<?php

if (strlen(session_id())<1)
    session_start();

require '../modelos/conexiones.php';
$conexionc=new conexiones_c;
$idconexion=isset($_POST['idconexion'])? limpiarCadena($_POST['idconexion']):"";
$contenedor=isset($_POST['contenedor'])? limpiarCadena($_POST['contenedor']):"";
$id_ingreso= isset($_POST['idingreso'])? limpiarCadena($_POST['idingreso']):"";
$fechaconexion=isset($_POST['fechaco'])? limpiarCadena($_POST['fechaco']):"";
$horaconexion=isset($_POST['horaconexion'])? limpiarCadena($_POST['horaconexion']):"";
$retorno=isset($_POST['retorno'])? limpiarCadena($_POST['retorno']):"";
$setpoint= isset($_POST['setpoint'])? limpiarCadena($_POST['setpoint']):"";
$suministro= isset($_POST['suministro'])? limpiarCadena($_POST['suministro']):"";
$idf=isset($_POST['idf'])? limpiarCadena($_POST['idf']):"";
$temperatura= isset($_POST['temperatura'])? limpiarCadena($_POST['temperatura']):"";
$tipoconexion= isset($_POST['tipoconexion'])? limpiarCadena($_POST['tipoconexion']):"";
$user_id=$_SESSION['idusuario'];

switch ($_GET['op']){
    case 'guardaryeditar':
        if (empty($idconexion)){
            $rspta=$conexionc->insertar($fechaconexion, $horaconexion, $setpoint, $suministro, $retorno, $id_ingreso, $idf, $user_id,$temperatura,$tipoconexion);
             echo $rspta ? 'Se realizo Exitosamente la conexion':'Error al realizar el ingreso a la conexion';
        }else{
           $rspta=$conexionc->editar($idconexion,$fechaconexion, $horaconexion, $setpoint, $suministro, $retorno, $id_ingreso, $idf,$temperatura,$tipoconexion);
           echo $rspta ? 'Se Actualizo correctaente el registro':'Error al tratar de actualizar el registro';
        }
        break;
    
    case 'listar':
        $rspta=$conexionc->listar();
        $datosc=array();
        
        while ($reg=$rspta->fetch_object()){
            $datosc[]=array(
                "0"=>$reg->No_Contenedor,
                "1"=>$reg->Fecha_Conexion,
                "2"=>$reg->Hora_De_Conexion,
                "3"=>$reg->Setpoint,
                "4"=>$reg->Suministro,
                "5"=>$reg->Retorno,
                "6"=>$reg->Id_Ingreso,
                "7"=>$reg->Cabezal,
                "8"=>$reg->Nombre_de_Piloto,
                "9"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->Id.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Monitoreo"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->Id.')"><i class="fa fa-close" data-toggle="tooltip" data-placement="top" title="Anular Monitoreo"></i></button> '
            );
        }
        $results=array(
             "sEcho"=>1,
            "iTotalRecords"=> count($datosc),
            "iTotalDisplayRecords"=> count($datosc),
            "aaData"=>$datosc
        );
        echo json_encode($results);
        break;
        case 'mostraringreso':
            
            $idingreso=$_REQUEST['idingreso'];
            $rspta=$conexionc->datosingreso($idingreso);
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
        case 'mostrar':
            $idcon=$_REQUEST['idconexion'];
            $rspta=$conexionc->mostrarco($idcon);
            echo json_encode($rspta);
            break;
    case 'desactivar':
        $idcon=$_REQUEST['id_c'];
        $rspta=$conexionc->desactivar($idcon);
        echo $rspta ? "Conexion desactivados correctamente" : "No se pudo desactivar el Registro";
        break;
    case 'listaringreso':
        $rspta=$conexionc->listar_ingreso();
        echo '<option value="0">Selecione Ingreso</option>';
        while ($reg=$rspta->fetch_object()){
            echo '<option value='.$reg->Id_Ingreso.'>'.$reg->Id_Ingreso.'-'.$reg->No_Contenedor.'</option>';
        }
        break;
        
}