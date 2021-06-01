<?php

session_start();
require '../modelos/exportacion.php';
require '../modelos/bitacora.php';

date_default_timezone_set("America/Guatemala");
$exportacion_c=new exportacion();
$bitacora=new bitacora();
$idexpo= isset($_POST['idexportacion'])? limpiarCadena($_POST['idexportacion']):'';
$fechaexpo=isset($_POST['fecha'])? limpiarCadena($_POST['fecha']):'';
$fechaasign=isset($_POST['fecha_asig'])? limpiarCadena($_POST['fecha_asig']):'';
$horaexpo=isset($_POST['hora'])? limpiarCadena($_POST['hora']):'';
$ingreso=isset($_POST['idingresoc'])? limpiarCadena($_POST['idingresoc']):'';
$idflota= isset($_POST['idf'])? limpiarCadena($_POST['idf']):'';
$user_id=$_SESSION['idusuario'];
$hoy = date("Y/m/d");
$hora_actual=date("H:i:s");

switch ($_GET['op']){
    case 'listar':
        $rspta=$exportacion_c->listar();
        $datos=array();
            while ($reg=$rspta->fetch_object()){
                $opcion="";
                    if ($reg->estado=='Activo'){
                        $opcion='<button class="btn btn-danger btn-xs" onclick="dasactivar('.$reg->Id_e.','.$reg->Id_Ingreso.')"><i class="fa fa-close" data-toggle="tooltip" data-placement="top" title="Anular Exportacion"></i></button> ';
                    }
                $datos[]=array(
                    "0"=>$reg->Fecha_salida,
                    "1"=>$reg->Hora_Salida,
                    "2"=>$reg->No_Contenedor,
                    "3"=>$reg->Nombre_de_Piloto,
                    "4"=>$reg->Licencias,
                    "5"=>$reg->Barco,
                    "6"=>$reg->estado,
                    "7"=>$reg->Estado_c,
                    "8"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->Id_e.')"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Editar Exportacion"></i></button>'.' '.$opcion
                );
            }
            $r=array( "sEcho"=>1,
                "iTotalRecords"=>count($datos),
                "iTotalDisplayRecords"=>count($datos),
                "aaData"=>$datos
                );
                echo json_encode($r);
        break;
    case 'listaringreso':
        $rspta=$exportacion_c->listar_contenedores();
        echo '<option value="0">Seleccione...</option>';
            while ($reg=$rspta->fetch_object()){
                echo '<option value='.$reg->Id_Ingreso.'>'.$reg->Id_Ingreso.'-'.$reg->No_Contenedor.'</option>';
            }
        break;
    case 'mostrarcontenedor':
        $idconte=$_REQUEST['idingresoc'];
        $rspta=$exportacion_c->datoscontenedor($idconte);
         while ($row= mysqli_fetch_array($rspta)){
             echo '<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Tara:</label><input type="text" class="form-control" id="tara" name="tara" value="'.$row['tara'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Transportista</label><input type="text" class="form-control" value="'.$row['Transporte'].'" disabled="true"><input type="hidden" id="naviera" name="naviera" value="'.$row['Transporte'].'" > </div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Piloto</label><input type="text" class="form-control" value="'.$row['Nombre_de_Piloto'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Licencia</label><input type="text" class="form-control" value="'.$row['Licencias'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Placas</label><input type="text" class="form-control" value="'.$row['Placas'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-2 col-md-3 col-xs-12"><label>Codigo</label><input type="text" class="form-control" value="'.$row['Codigo_Piloto_Naviera'].'" disabled="true"></div>'
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Destino</label><input type="text" class="form-control"  value="'.$row['Destino'].'" disabled="true"><input type="hidden" id="destino" name="destino" value="'.$row['Destino'].'"><input type="hidden" id="idf" name="idf" value="'.$row['Id_f'].'"></div>' 
                .'<div class="form-group col-lg-3 col-md-3 col-xs-12"><label>Barco</label><input type="text" class="form-control" value="'.$row['Barco'].'" disabled="true"></div>';

         }
         
        break;
    case 'guardareditar':
        if (empty($idexpo)){
            $rspta=$exportacion_c->insertar($fechaexpo,$horaexpo,$fechaasign,$ingreso,$idflota,$user_id);
            if ($rspta==true){
                $bitacora->insertar_bitacora('Insertar', $hoy, $hora_actual, $_SESSION['nombre'], 'Inserta nueva exportacion', 'exportacion');
            }
            echo $rspta ? 'Se inserto el registro de la exportacion existosamente ': 'Error se ha generado un error al insertar el registro consultar log de errores' ;
        }else{
            $rspta=$exportacion_c->actualizar($idexpo,$fechaexpo,$horaexpo,$fechaasign,$ingreso,$idflota);
            if ($rspta==true){
                $bitacora->insertar_bitacora('Actualizar', $hoy, $hora_actual, $_SESSION['nombre'], 'Se actualiza el registro no. '.$idexpo , 'exportacion');
            }
            echo $rspta ? 'Se Actualizo el registro de exportacion exitosamente':'Error al modificar el exportacion revisar log de errores';
        }
        break;
    case 'anular':
        $id_expo=$_REQUEST['idexpo'];
        $id_ingre=$_REQUEST['id_ingreso'];
        $usuario_anula=$_REQUEST['usuarioa'];
        $rspta=$exportacion_c->anular($id_expo,$id_ingre);
        
        if ($rspta==true){
            $bitacora->insertar_bitacora("Anulacion", $hoy, $hora_actual, $usuario_anula, 'Anulacion de Resgistro Exportacion no:'.$id_expo, 'exportacion');
        }
        echo $rspta ? 'Se ha Anulado la Exportacion correctamente':'Error: No se ha podido anular la exportacion Verificar Log';
        break;
    case 'mostrar':
        $idexportacion=$_REQUEST['id_exportacion'];
        $rspta=$exportacion_c->mostrar($idexportacion);
        echo json_encode($rspta);
        break;
}